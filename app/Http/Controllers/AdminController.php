<?php

namespace App\Http\Controllers;

use App\Model\AdminGroupModel;
use App\Model\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private $fields = ['id', "group_id", "name", "email", "created_at"];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new AdminModel();
        $groupModel = new AdminGroupModel();
        $list = $model->getList($this->fields, ['isDel' => 0]);
        $groupList = $groupModel->getList(['*'], ['isDel' => 0]);
        foreach ($list as $key => $item) {
            foreach ($groupList as $group) {
                if ($item->group_id == $group->id) {
                    $list[$key]->group_name = $group->name;
                    break;
                }
            }
        }

        $this->pageData['list'] = $list;
        $this->pageData['groupList'] = $groupList;

        return view('admin/index', $this->pageData);
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
            'group_id' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required',
        ];
        $message = [
            'name.required' => '姓名必填',
            'group_id.required' => '用户组必填',
            'email.required' => '登录邮箱必填',
            'email.unique' => '此登录邮箱已被使用',
            'password.required' => '密码必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        (new AdminModel())->insert([
            'group_id' => $data['group_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return redirect('/admins');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $groupModel = new AdminGroupModel();
        $groupList = $groupModel->getList(['*'], ['isDel' => 0]);
        $this->pageData['groupList'] = $groupList;
        $this->pageData['row'] = (new AdminModel())->getOne($this->fields, ['id' => $id]);
        return view('admin/edit', $this->pageData);
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
        $data = $request->all();
        $rule = [
            'name' => 'required',
            'group_id' => 'required',
        ];
        $message = [
            'name.required' => '姓名必填',
            'group_id.required' => '用户组必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new AdminModel();
        $model->updateData([
            'name' => $data['name'],
            'group_id' => $data['group_id'],
        ], ['id' => $id]);

        return redirect('admins');
    }

    /**
     * 重置密码
     * @param Request $request
     */
    public function resetPwd(Request $request) {
        $id = $request->post("id");
        $model = new AdminModel();
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
        $model = new AdminModel();
        $ok = $model->find($id)->delete();
        exit(json_encode(['code' => 0, 'msg' => '删除成功:']));
    }
}
