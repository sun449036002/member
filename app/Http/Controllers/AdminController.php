<?php

namespace App\Http\Controllers;

use App\Model\AdminGroupModel;
use App\Model\AdminModel;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private $fields = ['id', 'pid', "group_id", "name", "email", "created_at", "is_spread", "tel"];

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
            //用户组
            foreach ($groupList as $group) {
                if ($item->group_id == $group->id) {
                    $list[$key]->group_name = $group->name;
                    break;
                }
            }

            //引荐人
            $list[$key]->referrer = "";
            if ($item->pid > 0) {
                foreach ($list as $subItem) {
                    if ($item->pid == $subItem->id) {
                        $list[$key]->referrer = $subItem->name;
                        break;
                    }
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
            'pid' => $data['pid'],
            'group_id' => $data['group_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tel' => $data['tel'],
            'is_spread' => $data['is_spread'] ?? 0,
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
        $adminModel = new AdminModel();
        $adminList = $adminModel->getList(['id', 'name', 'group_id'], ['isDel' => 0, ['id', '<>', $id]]);

        $groupModel = new AdminGroupModel();
        $groupList = $groupModel->getList(['*'], ['isDel' => 0]);

        foreach ($adminList as $key => $item) {
            foreach ($groupList as $group) {
                if ($item->group_id == $group->id) {
                    $adminList[$key]->group_name = $group->name;
                    break;
                }
            }
        }

        $this->pageData['adminList'] = $adminList;
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
            'pid' => $data['pid'],
            'group_id' => $data['group_id'],
            'name' => $data['name'],
            'tel' => $data['tel'],
            'is_spread' => $data['is_spread'] ?? 0,
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
        //假性删除
        $model = new AdminModel();
        $model->find($id)->delete();
        exit(json_encode(['code' => 0, 'msg' => '删除成功:']));
    }

    /**
     * 我推广的资源
     */
    public function show(Request $request) {
        $adminId = $request->get("adminId");
        $userModel = new UserModel();
        $userList = $userModel->getList(['id', 'username', 'avatar_url', 'subscribe_time'], ['admin_id' => $adminId]);
        foreach ($userList as $user) {
            $user->avatar_url = headImgUrl($user->avatar_url);
            $user->subscribe_time = date("Y-m-d H:i:s", $user->subscribe_time);
        }

        $this->pageData['list'] = $userList;

        return SView('/admin/resources', $this->pageData);
    }

    public function resourceTransfer(Request $request) {
        $fromAdminId = $request->post("fromAdminId");
        $toAdminId = $request->post("toAdminId");

        if (empty($fromAdminId) || empty($toAdminId)) {
            return ResultClientJson(100, '缺少必要参数');
        }

        //检测TO ADMIN ID 是否开通了推广功能
        $admin = (new AdminModel())->getOne(['name', 'is_spread'], ['id' => $toAdminId]);
        if (empty($admin->is_spread)) {
            return ResultClientJson(100, $admin->name . ' 未开通推广功能，请先开通推广功能再转移');
        }

        //显示转移多少用户
        $userModel = new UserModel();
        $count = $userModel->where("admin_id", $fromAdminId)->count();

        $userModel->updateData(['admin_id' => $toAdminId], ['admin_id' => $fromAdminId]);

        return ResultClientJson(0, '转移成功，共转移' . $count . "个用户资源");
    }
}
