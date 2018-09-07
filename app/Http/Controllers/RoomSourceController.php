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
use App\Model\HouseTypeModel;
use App\Model\RoomCategoryModel;
use App\Model\RoomSourceModel;
use App\Model\RoomTagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomSourceController extends Controller
{
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

        $houseTypeArr = [];
        foreach ($this->pageData['houseTypeList'] as $houseType) {
            $houseTypeArr[$houseType->id] = $houseType->name;
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


        $model->updateData($updateData, ['id' => $data['id']]);

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