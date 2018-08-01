<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 18:55
 */

namespace App\Http\Controllers;


use App\Model\RoomCategoryModel;
use App\Model\RoomSourceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomSourceController extends Controller
{
    //房源分类列表
    public function index() {
        $list = (new RoomSourceModel())->getList(['*'], ['isDel' => 0]);
        $this->pageData['list'] = $list;
        return SView("RoomSource/index", $this->pageData);
    }

    public function add() {
        $model = new RoomCategoryModel();
        $this->pageData['categoryList'] = $model->getList(['*'], ['isDel' => 0]);
        return SView("RoomSource/add", $this->pageData);
    }

    public function doAdd(Request $request) {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '房源类别名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }
        $model = new RoomSourceModel();
        $model->insert(['name' => $data['name']]);

        return redirect("/RoomSource");
    }

    public function edit(Request $request) {
        $data = $request->all();
        $rule = [
            'id' => 'required',
        ];
        $message = [
            'id.required' => '房源类别ID必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }
        $model = new RoomSourceModel();
        $this->pageData['row'] = $model->getOne(['*'], ['id' => $data['id']]);

        return SView('/RoomSource/edit', $this->pageData);
    }

    public function doEdit(Request $request) {
        $data = $request->all();
        $rule = [
            'id' => 'required',
            'name' => 'required',
        ];
        $message = [
            'id.required' => '房源类别ID必填',
            'name.required' => '房源类别名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }
        $model = new RoomSourceModel();
        $model->updateData(['name' => $data['name']], ['id' => $data['id']]);

        return redirect("/RoomSource");
    }

    public function del(Request $request) {
        $data = $request->all();
        if (empty($data['id'])) {
            exit(json_encode(['code' => 100, 'msg' => '房源类别ID不得为空'], JSON_UNESCAPED_UNICODE));
        }

        $model = new RoomSourceModel();
        $model->updateData(['isDel' => 1], ['id' => $data['id']]);

        exit(json_encode(['code' => 0, 'msg' => '删除成功'], JSON_UNESCAPED_UNICODE));
    }

}