<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 15:15
 */

namespace App\Http\Controllers;


use App\Model\MenuModel;
use EasyWeChat\Factory;
use Illuminate\Http\Request;

class CustomMenuController extends Controller
{
    private $wxapp = null;

    public function __construct()
    {
        parent::__construct();
        $this->wxapp = Factory::officialAccount(getWxConfig());
    }

    /**
     * 菜单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $model = new MenuModel();
        $menuList = $model->getList(["*"], ['isDel' => 0]);
        return view("weixin/custom-menu", ['menuList' => $menuList]);
    }

    /**
     * 编辑菜单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request) {
        $id = $request->get("id");
        if (empty($id)) {
            redirect("/weixin/custom-menu");
        }

        $model = new MenuModel();
        $row = $model->getOne("*", ['id' => $id]);

        return view('/weixin/custom-menu-edit', ['row' => $row]);
    }

    /**
     * 提交编辑
     * @param Request $request
     * @return null
     */
    public function doEdit(Request $request) {
        $model = new MenuModel();
        $id = $request->post("id");
        $name = $request->post("name");
        $url = $request->post("url");
        if (empty($id) || empty($name)) {
            redirect("/weixin/custom-menu");
        }
        $menus = $model->getList('*', [['id', '<>', $id], 'isDel' => 0]);

        $buttons = [];
        foreach ($menus as $menu) {
            $buttons[] = [
                "type" => $menu->type,
                "name" => $menu->name,
                "url"  => $menu->url
            ];
        }
        $menuData = [
            "type" => "view",
            "name" => $name,
            "url"  => $url
        ];
        $buttons[] = $menuData;
        //触发接口
        $result = $this->wxapp->menu->create($buttons);
        if (empty($result['errcode'])) {
            $model->updateData($menuData, ['id' => $id]);
            return redirect('/weixin/custom-menu');
        } else {
            return $result['errmsg'];
        }
    }

    /**
     * 创建菜单
     * @param Request $request
     * @return string
     */
    public function create(Request $request) {
        $name = $request->input("name", '');
        $url = $request->input("url", '');
        if (empty($name)) {
            return 'name is empty';
        }

        //获取原有的菜单
        $model = new MenuModel();
        $menuList = $model->getList(["*"], ['isDel' => 0]);
        $buttons = [];
        foreach ($menuList as $menu) {
            $buttons[] = [
                "type" => $menu->type,
                "name" => $menu->name,
                "url"  => $menu->url
            ];
        }

        //新添加按钮
        $menuData = [
            "type" => "view",
            "name" => $name,
            "url"  => $url
        ];
        $buttons[] = $menuData;

        //触发接口
        $result = $this->wxapp->menu->create($buttons);
        if (empty($result['errcode'])) {
            $model->insert(array_merge($menuData, [
                'createTime' => date("Y-m-d H:i:s")
            ]));
            return redirect('/weixin/custom-menu');
        } else {
            return $result['errmsg'];
        }
    }

    /**
     * 删除全部自定义菜单
     */
    public function del(Request $request) {
        $id = $request->post("id");
        if (empty($id)) {
            exit(json_encode(['code' => 100, 'msg' => 'id为空'], JSON_UNESCAPED_UNICODE));
        }

        //获取原有的菜单
        $model = new MenuModel();
        $menuList = $model->getList(["*"], [['id', '<>', $id], 'isDel' => 0]);
        $buttons = [];
        foreach ($menuList as $menu) {
            $buttons[] = [
                "type" => $menu->type,
                "name" => $menu->name,
                "url"  => $menu->url
            ];
        }

        //触发接口
        $result = $this->wxapp->menu->create($buttons);
        if (empty($result['errcode'])) {
            $model->updateData(['isDel' => 1], ['id' => $id]);
            return ['code' => 0, 'msg' => 'ok'];
        } else {
            return ['code' => 100, 'msg' => $result['errmsg'] || 'Failed'];
        }
    }

}