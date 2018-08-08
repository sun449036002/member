<?php

namespace App\Http\Controllers;

use App\Model\AdminGroupModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new AdminGroupModel();
        $this->pageData['list'] = $model->getList(['*'], ['isDel' => 0]);
        return view('adminGroup/index', $this->pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '分组名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        (new AdminGroupModel())->insert(['name' => $data['name']]);

        return redirect("adminGroups");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->pageData['row'] = (new AdminGroupModel())->getOne(['*'], ['id' => $id]);
        return SView('adminGroup/edit', $this->pageData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = new AdminGroupModel();
        $pwd = mt_rand(100000, 999999);
        $model->updateData(['password' => Hash::make($pwd)], ['id' => $id]);
        exit(json_encode(['code' => 0, 'msg' => '密码已经重置，默认密码为:' . $pwd]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $model = new AdminGroupModel();
        dd($model->where(['id' => $id]));
        $ok = $model->find($id)->delete();
        exit(json_encode(['code' => 0, 'msg' => '删除成功:']));
    }
}
