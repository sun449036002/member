<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/28
 * Time: 15:41
 */

namespace App\Http\Controllers;


use App\Model\HubModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Parser\Reader;

class HubController extends Controller
{
    /**
     * 栏目列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        //一级栏目
        $model = new HubModel();
        $list = $model->getHubList();

        if (!empty($list)) {
            foreach ($list as $key => $hub) {
                $list[$key]->sublist = $model->getHubList($hub->id);
            }
        }

        return view('/hub/index', ['list' => $list]);
    }

    public function doAdd(Request $request) {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '栏目名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new HubModel();
        $model->insert([
            'name' => $data['name'],
            'pid' => $data['pid']
        ]);

        return redirect('/hub');
    }

    public function edit(Request $request) {
        $data = $request->all();
        $validate = Validator::make($data, ['id' => 'required'], ['id.required' => 'id不得为空']);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new HubModel();
        $row = $model->getOne(['id', 'pid', 'name'], ['id' => $data['id']]);
        if (!empty($row->pid)) {
            $subRow = $model->getOne(['name'], ['id' => $row->pid]);
            $row['subName'] = $subRow->name;
        }

        return view("/hub/edit", ['data' => $row]);
    }

    public function doEdit() {

    }

    public function del() {

    }

}