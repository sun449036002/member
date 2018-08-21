<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 13:54
 */

namespace App\Http\Controllers;


use App\Model\CashbackModel;
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

    /**
     * 返现申请列表
     */
    public function cashBack() {
        $list = (new CashbackModel())->getList(['*']);

        $this->pageData['list'] = $list;
        return SView('redPack/cashBack', $this->pageData);
    }

    /**
     * 返现详情
     * @param Request $request
     * @return object
     */
    public function cashBackDetail(Request $request) {
        $id = $request->get("id");
        $row = (new CashbackModel())->getOne(['*'], ['id' => $id]);
        if (empty($row)) {
            return back()->withErrors("不存在此返现详情");
        }

        $imgs = json_decode($row->imgs, true);
        if (!empty($imgs)) {
            foreach($imgs as $key => $img) {
                $imgs[$key] = env('APP_IMG_DOMAIN') . $img;
            }
        }
        $row->imgs = $imgs;

        $row->paymentMethodList = json_decode($row->paymentMethod);
        $this->pageData['row'] = $row;

        return SView('redPack/cashBackDetail', $this->pageData);
    }

    /***
     * 返现审查
     * @param Request $request
     */
    public function cashBackExamine(Request $request) {
        $id = $request->get("id");

    }

}