<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 22:04
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ImgController
{

    /**
     * 图片上传
     * @param Request $request
     * @return false|string|array
     */
    public function upload(Request $request) {
        $data = $request->all();
        $dirName = "/images/room-source/" . date("Ymd");
        if (!empty($data['cover'])) {
            $filePath = $request->file("cover")->store($dirName);
            return $filePath;
        } else if (!empty($data['imgs'])) {
            $filePath = [];
            foreach ($data['imgs'] as $key => $img) {
                $filePath[] = $request->file($key)->store($dirName);
            }
            return $filePath;
        }
        return '';
    }
}