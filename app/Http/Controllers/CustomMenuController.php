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
        $this->wxapp = Factory::officialAccount(getWxConfig());
    }

    /**
     * 菜单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $user = $this->wxapp->user->get("o1siQ0TJfaFjIdoAJvzxGQHCVQJM");
        dd($user);
        $model = new MenuModel();
        $menuList = $model->getList(["*"], ['isDel' => 0]);
        return view("weixin/custom-menu", ['menuList' => $menuList]);
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
    public function del() {
        $model = new MenuModel();
        $model->updateData(['isDel' => 1], ['isDel' => 0]);
        return $this->wxapp->menu->delete();
    }

}