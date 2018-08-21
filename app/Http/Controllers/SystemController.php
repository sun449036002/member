<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/21
 * Time: 16:13
 */

namespace App\Http\Controllers;


use App\Model\SystemModel;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    //关于我们
    public function aboutUs() {
        $this->pageData['row'] = (new SystemModel())->getOne(['*'], []);
        return SView('/system/aboutUs', $this->pageData);
    }

    //更新关于我们
    public function saveAboutUs(Request $request) {
        $data = $request->all();
        $id = $data['id'];

        $data = [
            'smsTel' => $data['smsTel'],
            'aboutUs' => $data['aboutUs']
        ];

        $model = new SystemModel();
        if (!empty($id)) {
            $model->updateData($data, ['id' => $id]);
        } else {
            $model->insert($data);
        }

        return ResultClientJson(0, '保存成功');
    }

}