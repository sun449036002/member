<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 11:00
 */

namespace App\Http\Controllers;

use App\Model\RedPackModel;
use App\Model\RedPackRecordModel;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $subscribeChannel = [
        'ADD_SCENE_SEARCH' => '通过搜索关注',
        'ADD_SCENE_QR_CODE' => '通过二维码关注',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->pageData['subscribeChannel'] = $this->subscribeChannel;
    }

    //用户列表
    public function index() {
        $model = new UserModel();
        $list = $model->getUserList();

        $this->pageData['list'] = $list;
        return SView("user/index", $this->pageData);
    }

    //用户详情
    public function detail(Request $request) {
        $data = $request->all();
        $rule = [
            'id' => 'required'
        ];
        $message = [
            'id.required' => '用户ID必填'
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $user = (new UserModel())->getUserAllInfo($data['id']);
//        echo "<pre>";
//        print_R($user);
//        exit;
        $this->pageData['row'] = $user;

        //我的红包数量
        $redPackModel = new RedPackModel();
        $redPackList = $redPackModel->getList(['status'], ['userId' => $user->id]);
        $this->pageData['redPackCount'] = count($redPackList);

        //我的助力次数
        $recordModel = new RedPackRecordModel();
        $recordList = $recordModel->getList(['id'], ["userId" => $user->id]);
        $this->pageData['recordCount'] = count($recordList);

        return SView("user/detail", $this->pageData);
    }

    //冻结用户
    public function lock(Request $request) {
        $data = $request->all();
        $rule = [
            'id' => 'required'
        ];
        $message = [
            'id.required' => '用户ID必填'
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new UserModel();
        $where = ['id' => $data['id']];
        $row = $model->getOne(['lock'], $where);
        $model->updateData(['lock' => !$row->lock], $where);

        return ResultClientJson(0, '操作成功');
    }

}