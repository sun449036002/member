<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/28
 * Time: 15:41
 */

namespace App\Http\Controllers;


use App\Logic\HubLogic;
use App\Model\HubModel;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HubController extends Controller
{
    //一级栏目限制个数
    private $maxRootButtonSize = 3;

    //二级栏目限制个数
    private $maxSecondButtonSize = 5;

    /**
     * 栏目列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $list = (new HubLogic())->getMenuList();
        $this->pageData['list'] = $list;

        return view('/hub/index', $this->pageData);
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

        //检测菜单数量限制
        $checkResult = $this->checkButtonSize($data['pid']);
        if (is_string($checkResult)) {
            return back()->withErrors($checkResult);
        }

        $model = new HubModel();
        $model->insert([
            'pid' => $data['pid'],
            'name' => $data['name'],
            'url' => $data['url']
        ]);

        //创建公众号菜单
        $this->createWxMenus($data);

        return redirect('/hub');
    }

    public function edit(Request $request) {
        $data = $request->all();
        $validate = Validator::make($data, ['id' => 'required'], ['id.required' => 'id不得为空']);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        $model = new HubModel();
        $row = $model->getOne(['*'], ['id' => $data['id']]);
        if (!empty($row->pid)) {
            $subRow = $model->getOne(['name'], ['id' => $row->pid]);
            $row->subName = $subRow->name;
        }

        //取得一级栏目名称 排除自身
        $list = $model->getHubList();
        foreach ($list as $key => $val) {
            if ($val->id == $row->id) unset($list[$key]);
        }

        $this->pageData['row'] = $row;
        $this->pageData['list'] = $list;

        return view("/hub/edit", $this->pageData);
    }

    public function doEdit(Request $request) {
        $data = $request->all();
        $rule = [
            'id' => 'required',
            'name' => 'required',
        ];
        $message = [
            'id.required' => 'ID不得为空',
            'name.required' => '栏目名称必填',
        ];
        $validate = Validator::make($data, $rule, $message);
        if (!$validate->passes()) {
            return back()->withErrors($validate);
        }

        //检测菜单数量限制
        $checkResult = $this->checkButtonSize($data['pid']);
        if (is_string($checkResult)) {
            return back()->withErrors($checkResult);
        }

        $model = new HubModel();
        $model->updateData([
            'pid' => $data['pid'],
            'name' => $data['name'],
            'url' => $data['url']
        ], ['id' => $data['id']]);

        //创建公众号菜单
        $this->createWxMenus();

        return redirect('/hub');
    }

    public function del(Request $request) {
        $id = $request->post("id");
        (new HubModel())->updateData(['isDel' => 1], ['id' => $id]);

        //创建公众号菜单
        $this->createWxMenus();

        return ResultClientJson(0, '删除成功');
    }


    /**
     * 创建微信菜单
     * @param array $data
     */
    private function createWxMenus($data = []) {
        //创建公众号菜单
        $buttons = (new HubLogic())->getMenuButtons();
        if (!empty($data)) {
            if (!empty($data['pid'])) {
                $subs = $buttons[$data['pid']]['sub_button'] ?? [];
                $subs[] = [
                    'type' => 'view',
                    'name' => $data['name'],
                    'url' => $data['url'] ?: env('APP_URL')
                ];
                $buttons[$data['pid']]['sub_button'] = $subs;
            } else {
                $buttons[] = [
                    'type' => 'view',
                    'name' => $data['name'],
                    'url' => $data['url'] ?: env('APP_URL')
                ];
            }
        }

        $buttons = array_values($buttons);
        $wxApp = Factory::officialAccount(getWxConfig());
        $wxApp->menu->delete();//先全部删除
        $wxApp->menu->create($buttons);//再全部重建
    }

    /**
     * 检测菜单数量限制
     * @param int $pid
     * @return bool|string
     */
    private function checkButtonSize($pid = 0) {
        $count = (new HubModel())->where("pid", $pid)->count();

        $limitCount = $pid > 0 ? $this->maxSecondButtonSize : $this->maxRootButtonSize;

        if ($count >= $limitCount) {
            return ($pid > 0 ? "二" : "一") . "级栏目已达到最大个数({$limitCount}个)，不能再创建";
        } else {
            return true;
        }
    }

}