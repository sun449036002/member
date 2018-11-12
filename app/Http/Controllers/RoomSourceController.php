<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 18:55
 */

namespace App\Http\Controllers;


use App\Logic\BespeakLogic;
use App\Model\AdminModel;
use App\Model\AreaModel;
use App\Model\BespeakModel;
use App\Model\BrokerApplyModel;
use App\Model\HouseTypeModel;
use App\Model\RoomCategoryModel;
use App\Model\RoomSourceModel;
use App\Model\RoomTagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomSourceController extends Controller
{
    /**
     * 不限制修改房源信息的用户，其他用户(只能编辑自己上传的房源)
     * @var array
     */
    private $superAdminId = [8];

    public function __construct()
    {
        parent::__construct();

        $this->pageData['areaList'] = $this->getAreaList();
        $this->pageData['houseTypeList'] = $this->getHouseTypeList();
        $this->pageData['roomTags'] = $this->getTags();
    }

    //房源分类列表
    public function index() {
        $areaArr = [];
        foreach ($this->pageData['areaList'] as $area) {
            $areaArr[$area->id] = $area->name;
        }

        //户型
        $houseTypeArr = [];
        foreach ($this->pageData['houseTypeList'] as $houseType) {
            $houseTypeArr[$houseType->id] = $houseType->name;
        }

        //分类
        $categoryNameArr = [];
        $categoryList = (new RoomCategoryModel())->getList(['*'], ['isDel' => 0]);
        foreach ($categoryList as $item) {
            $categoryNameArr[$item->id] = $item->name;
        }

        $admins = [];
        $adminList = (new AdminModel())->getList(['id', 'name'], ['isDel' => 0]);
        foreach ($adminList as $admin) {
            $admins[$admin->id] = $admin->name;
        }

        $list = (new RoomSourceModel())->getList(['*'], ['isDel' => 0], ['id', "desc"]);
        foreach ($list as $item) {
            $item->adminName = $admins[$item->adminId] ?? "未知";
            $item->area = $areaArr[$item->areaId] ?? "未知";
            $item->houseType = $houseTypeArr[$item->houseTypeId] ?? "未知";
            $item->categoryName = $categoryNameArr[$item->roomCategoryId] ?? "未知";

            $imgs = json_decode($item->imgJson, true);

            $item->hasCover = !empty($imgs['cover']);
            $item->hasLoopImg = !empty($imgs['imgs']);
            $item->hasHouseTypeImg = !empty($imgs['houseTypeImgs']);
        }
        $this->pageData['list'] = $list;
        return SView("roomSource/index", $this->pageData);
    }

    public function add() {
        $model = new RoomCategoryModel();
        $this->pageData['categoryList'] = $model->getList(['*'], ['isDel' => 0]);
        return SView("roomSource/add", $this->pageData);
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
        $model->insert([
            'adminId' => Auth::user()->getAuthIdentifier(),
            'name' => $data['name'],
            'type' => $data['type'],
            'areaId' => $data['areaId'],
            'roomCategoryId' => $data['roomCategoryId'],
            'totalPrice' => $data['totalPrice'],
            'avgPrice' => $data['avgPrice'],
            'acreage' => $data['acreage'],
            'decoration' => $data['decoration'],
            'firstPay' => $data['firstPay'],
            'houseTypeId' => $data['houseTypeId'],
            'roomTagIds' => $data['tagIds'],
            'reportTemplate' => $data['reportTemplate'],
            'contacts' => $data['contacts'],
            'tel' => $data['tel'],
            'commission' => $data['commission'],
            'rewardPolicy' => $data['rewardPolicy'],
            'desc' => $data['desc'],
            'imgJson' => json_encode([
                'cover' => $data['cover'] ?? "",
                'imgs' => $data['imgs'] ?? [],
                'houseTypeImgs' => $data['houseTypeImgs'] ?? [],
            ], JSON_UNESCAPED_UNICODE),
            'createTime' => time(),
            'updateTime' => time(),
            'status' => ROOM_SOURCE_STATUS_PASS,
        ]);

        return json_encode(['code' => 0, 'msg' => '房源添加成功'],JSON_UNESCAPED_UNICODE);
    }

    public function edit(Request $request) {
        $data = $request->all();
        $rule = [
            'id' => 'required',
        ];
        $message = [
            'id.required' => '房源ID必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new RoomCategoryModel();
        $this->pageData['categoryList'] = $model->getList(['*'], ['isDel' => 0]);

        $model = new RoomSourceModel();
        $row = $model->getOne(['*'], ['id' => $data['id']]);
        if (!empty($row->desc)) {
            //处理内容中隐藏的\r\n，否则应用到JS后，脚本出错
            $row->desc = preg_replace_callback("/[\n\r]/", function($res){
                return '';
            }, $row->desc);
        }
        $this->pageData['row'] = $row;

        $this->pageData['roomTagIds'] = empty($row->roomTagIds) ? [] : explode(",", $row->roomTagIds);

//        dd($this->pageData['row']);

        return SView('/roomSource/edit', $this->pageData);
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
        $where = ['id' => $data['id']];
        $adminId = Auth::user()->getAuthIdentifier();
        $row = $model->getOne(['adminId'], $where);
        if (!in_array($adminId, $this->superAdminId) && $adminId != $row->adminId) {
            return json_encode(['code' => 100, 'msg' => '您没有权限修改此房源'],JSON_UNESCAPED_UNICODE);
        }
        $updateData = [
            //更新时，添加的操作员ID不作变更
            'name' => $data['name'],
            'type' => $data['type'],
            'areaId' => $data['areaId'],
            'roomCategoryId' => $data['roomCategoryId'],
            'totalPrice' => $data['totalPrice'],
            'avgPrice' => $data['avgPrice'],
            'acreage' => $data['acreage'],
            'decoration' => $data['decoration'],
            'firstPay' => $data['firstPay'],
            'houseTypeId' => $data['houseTypeId'],
            'roomTagIds' => $data['tagIds'],
            'reportTemplate' => $data['reportTemplate'],
            'contacts' => $data['contacts'],
            'tel' => $data['tel'],
            'commission' => $data['commission'],
            'rewardPolicy' => $data['rewardPolicy'],
            'desc' => $data['desc'],
            'imgJson' => json_encode([
                'cover' => $data['cover'] ?? "",
                'imgs' => $data['imgs'] ?? [],
                'houseTypeImgs' => $data['houseTypeImgs'] ?? []
            ], JSON_UNESCAPED_UNICODE),
            'updateTime' => time(),
        ];


        $model->updateData($updateData, $where);

        return json_encode(['code' => 0, 'msg' => '房源编辑成功'],JSON_UNESCAPED_UNICODE);
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

    /***
     * 预约列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bespeakList() {
        $this->pageData['list'] = (new BespeakLogic())->getBespeakList();
        return SView('roomSource/speaklist', $this->pageData);
    }

    /**
     * 预约状态变更
     * @param Request $request
     * @return string
     */
    public function bespeakChange(Request $request) {
        $id = $request->get("id");
        $status = $request->get("status", 0);
        if (empty($id)) {
            return ResultClientJson(100, '操作的预约ID错误');
        }

        (new BespeakModel())->updateData(['status' => $status], ['id' => $id]);

        return ResultClientJson(0, '操作成功');
    }

    /**
     * 同名房源检测
     */
    public function checkSameName(Request $request) {
        $name = $request->get("name");
        if (!empty($name)) {
            $total = (new RoomSourceModel())->where("name", $name)->count();
            if ($total > 0) {
                return ResultClientJson(100, '存在相同名称的房源');
            }
        }

        return ResultClientJson(0);
    }

    /**
     * 经纪人列表
     */
    public function brokerList() {
        $this->pageData['list'] = (new BrokerApplyModel())->getList(['*'], null);

        return SView('/roomSource/brokerlist', $this->pageData);
    }

    /**
     * 地域列表
     * @return array
     */
    private function getAreaList() {
        return (new AreaModel())->getList(['*'], ['isDel' => 0]);
    }

    /**
     * 户型列表
     * @return array
     */
    private function getHouseTypeList() {
        return (new HouseTypeModel())->getList(['*'], ['isDel' => 0]);
    }

    /**
     * 标签列表
     * @return array
     */
    private function getTags() {
        return (new RoomTagModel())->getList(['*'], ['isDel' => 0]);
    }
}