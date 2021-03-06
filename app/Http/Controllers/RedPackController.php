<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7
 * Time: 13:54
 */

namespace App\Http\Controllers;


use App\Consts\StateConst;
use App\Consts\WxConst;
use App\Model\BalanceLogModel;
use App\Model\CashbackModel;
use App\Model\RedPackConfigModel;
use App\Model\RedPackModel;
use App\Model\UserModel;
use App\Model\WithdrawModel;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RedPackController extends Controller
{
    //提现申请状态
    private $withdrawStatus = ["未审核", "通过", "驳回"];

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

        //红包信息
        $model = new RedPackModel();
        if (!empty($row->redPackIds) || !empty($row->friendRedPackIds)) {
            $redPackIds = array_filter(array_merge(explode(',', $row->redPackIds), explode(',', $row->friendRedPackIds)));
            $redPackList = $model->getList(['id', 'userId', 'fromUserId', 'total', 'received', 'status', 'useExpiredTime'], [['id', 'in', $redPackIds]]);
            $this->pageData['redPackList'] = $redPackList;
        }

        $row->paymentMethodList = json_decode($row->paymentMethod);
        $this->pageData['row'] = $row;

        return SView('redPack/cashBackDetail', $this->pageData);
    }

    /***
     * 返现审查
     * @param Request $request
     * @return object
     */
    public function cashBackExamine(Request $request) {
        $id = $request->post("id");
        $model = new CashbackModel();
        $row = $model->getOne(['redPackIds', 'friendRedPackIds'], ['id' => $id]);
        if (empty($row)) {
            return ResultClientJson(100, '不存在此返现申请数据');
        }

        //红包信息
        if (!empty($row->redPackIds) || !empty($row->friendRedPackIds)) {
            $redPackIds = array_merge(explode(',', $row->redPackIds), explode(',', $row->friendRedPackIds));
            (new RedPackModel())->updateData(['status' => StateConst::RED_PACK_USED], [["id", 'in', $redPackIds]]);
        }

        //更新申请状态
        $model->updateData(['status' => 1], ['id' => $id]);
        return ResultClientJson(0, '操作成功');
    }

    //提现申请列表
    public function withdraw() {
        $withdrawList = (new WithdrawModel())->getList(['*'], [], ['id', 'desc']);
        $this->pageData['list'] = $withdrawList;
        $this->pageData['withdrawStatus'] = $this->withdrawStatus;

        return SView('/redPack/withdraw', $this->pageData);
    }

    //提现申请详情
    public function withdrawDetail(Request $request) {
        $id = $request->get("id");
        $row = (new WithdrawModel())->getOne(['*'], ['id' => $id]);
        if (empty($row)) {
            return back()->withErrors("不存在此返现详情");
        }

        //红包信息
        $model = new RedPackModel();
        if (!empty($row->redPackIds)) {
            $redPackIds = explode(',', $row->redPackIds);
            $redPackList = $model->getList(['id', 'userId', 'fromUserId', 'total', 'received', 'status', 'useExpiredTime'], [['id', 'in', $redPackIds]]);
            $this->pageData['redPackList'] = $redPackList;
        }

        $row->createTime = date("Y-m-d H:i:s", $row->createTime);
        $row->paymentMethodList = json_decode($row->paymentMethod) ?: [];
        $this->pageData['row'] = $row;

        return SView("/redPack/withdrawDetail", $this->pageData);
    }

    //提现申请审查
    public function withdrawExamine(Request $request) {
        $id = $request->post("id");
        $status = $request->post("status");//1通过，2驳回
        $remark = $request->post("remark", "");//驳回原因

        $model = new WithdrawModel();
        $row = $model->getOne(['userId', 'redPackIds'], ['id' => $id]);
        if (empty($row)) {
            return ResultClientJson(100, '不存在此返现申请数据');
        }

        //通过操作，则把红包置为已使用状态
        if ($status == 1) {
            //红包信息
            if (!empty($row->redPackIds)) {
                $redPackIds = explode(',', $row->redPackIds);
                (new RedPackModel())->updateData(['status' => StateConst::RED_PACK_USED], [["id", 'in', $redPackIds]]);
            }
        }

        //发送模板消息给用户
        $isPass = $status == 1;
        $user = (new UserModel())->getOne(['openid'], ['id' => $row->userId]);
        Log::info('user', [$user]);
        if (!empty($user->openid)) {
            $wxapp = Factory::officialAccount(getWxConfig());
            $ok = $wxapp->template_message->send([
                'touser' => $user->openid,
                'template_id' => WxConst::TEMPLATE_ID_FOR_WITHDRAW_NOTICE,
                'url' => env('APP_URL') . "/my/balance",
                'data' => [
                    'first' => [
                        "value" => $isPass ? "您提交的提现申请已经审核通过" : "您提交的提现申请被驳回了",
                        "color" => "#169ADA"
                    ],
                    'keyword1' => "提现申请",
                    'keyword2' => [
                        "value" => $isPass ? '审核通过' : "审核未通过",
                        'color' => $isPass ? '#d22e20' : "#d222e0"
                    ],
                    'keyword3' => date("Y-m-d H:i:s"),
                    'remark' => $remark
                ],
            ]);
            Log::info('send msg', [$ok]);
        }

        //更新余额日志状态
        (new BalanceLogModel())->updateData(['type' => $isPass ? 2 : 3], ['targetId' => $id]);
        //更新申请状态
        $model->updateData(['status' => $status], ['id' => $id]);
        return ResultClientJson(0, '操作成功');
    }

    /**
     * 红包数据统计
     */
    public function statistics() {
        $model = new RedPackModel();

        $list = $model->getList(['*'], null, ['id', 'DESC']);

        $userIds = [];
        foreach ($list as $item) {
            if (!in_array($item->userId, $userIds)) {
                $userIds[] = $item->userId;
            }
        }

        //找红包的所属用户
        $userModel = new UserModel();
        $userList = $userModel->getList(['id', 'username'], [["id", "in", $userIds]]);
        $users = [];
        foreach ($userList as $user) {
            $users[$user->id] = $user->username;
        }

        //置入列表
        foreach ($list as $item) {
            $item->username = $users[$item->userId] ?? "";
        }

        $this->pageData['list'] = $list;

        return SView('redPack/statistics', $this->pageData);
    }

    /**
     * 红包数据统计2 图表
     */
    public function statistics2() {
        //近七天的红包数据
        $model = new RedPackModel();
        $beforeSevenDayTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d 00:00:00", strtotime("-7 days"))));

//        $model->getList(['id'], [''])

        return SView('redPack/statistics2', $this->pageData);
    }

}