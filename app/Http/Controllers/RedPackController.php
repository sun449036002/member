<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 13:54
 */

namespace App\Http\Controllers;


use App\Model\RedPackConfigModel;
use Illuminate\Http\Request;

class RedPackController extends Controller
{
    //获取配置
    public function config() {
        $model = new RedPackConfigModel();
        $rdConfig = $model->getOne(["*"], [['id', ">", 0]]);

        $this->pageData['rdConfig'] = $rdConfig;
        return SView("redPack/config", $this->pageData);
    }

    //保存配置
    public function saveConfig(Request $request) {
        $data = $request->all();

        $model = new RedPackConfigModel();
        if (empty($data['id'])) {
            unset($data['id']);
            $model->insert($data);
        } else {
            $id = $data['id'];
            unset($data['id']);
            $model->updateData($data, ['id' => $id]);

        }
        return json_encode(['code' => 0, 'msg' => "保存成功"]);
    }

}