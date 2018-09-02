<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 22:04
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImgController
{

    /**
     * 图片上传
     * @param Request $request
     * @return false|string|array
     */
    public function upload(Request $request) {
        $result = ['code' => 0, 'msg' => 'ok', 'imgs' => []];

        ini_set('memory_limit','100M');

        $data = $request->all();
        $destinationPath = "/images/room-source/" . date("Ymd");
        //先创建缩略图文件夹，否则缩略图不能正常生成
        $thumbnail_file_dir = "/images/room-source-thumbnail/" . date("Ymd");
        Storage::makeDirectory($thumbnail_file_dir);
        if (!empty($data['cover'])) {
            $coverFile = $request->file('cover');
            if (!$coverFile->isValid()) {
                $result['code'] = 100;
                $result['msg'] = $coverFile->getErrorMessage();
                return $result;
            }
            $filePath = $coverFile->store($destinationPath);
            $result['imgs'][] = "/" . ltrim($filePath, "/");

            //缩略图
            $thumbnail_file_path = storage_path() .  "/app/" . str_replace("room-source", 'room-source-thumbnail', $filePath);
//            dd($coverFile, $data['cover']);
            Image::make($data['cover'])->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnail_file_path);

            return $result;
        } else if (!empty($data['imgs'])) {
            $filePathList = [];
            $errorMsgs = [];
            foreach ($data['imgs'] as $key => $img) {
                if(!empty($img)){
                    // 判断图片上传中是否出错
                    if (!$img->isValid()) {
                        $errorMsgs[] = $img->getErrorMessage();
                        continue;
                    }

                    //此处防止没有多文件上传的情况
                    $allowed_extensions = ["png", "jpg", "gif"];
                    if ($img->getClientOriginalExtension() && !in_array($img->getClientOriginalExtension(), $allowed_extensions)) {
                        $errorMsgs[] = '您只能上传PNG、JPG或GIF格式的图片！';
                        continue;
                    }

                    $extension = $img->getClientOriginalExtension();   // 上传文件后缀
                    $fileName = date('YmdHis').mt_rand(100,999) . '.'.$extension; // 重命名
                    $filePath = $destinationPath.'/'.$fileName;

                    //缩略图
                    $thumbnail_file_path = storage_path() .  "/app/" . str_replace("room-source", 'room-source-thumbnail', $filePath);
                    Image::make($img)->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($thumbnail_file_path);

                    //移动保存原始图片
                    $img->move(storage_path() . "/app" . $destinationPath, $fileName);

                    $filePathList[] = $filePath;
                }
            }

            //若有错误，直接显示错误
            if (!empty($errorMsgs)) {
                $result['code'] = 100;
                $result['msg'] = join("#且#", $errorMsgs);
                return $result;
            }

            $result['imgs'] = $filePathList;
            return $result;
        }
        return $result;
    }
}