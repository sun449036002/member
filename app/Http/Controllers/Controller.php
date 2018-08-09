<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $pageData = [];

    public $admin = null;

    private $notAllowLoginMethods = ["showLoginForm", "login"];

    public function __construct()
    {
//        dd(Hash::make(123456));


        /**
         * 构造函数当中使用Session在Laravel以前的版本中，你可以在控制器构造函数中获取session变量或者认证后的用户实例。
         * 框架从未打算具有如此明显的特性。在Laravel 5.3中，你在控制器构造函数中不再能够直接获取到session变量或认证后的用户实例，因为中间件还未启动。
         * 仍然有替代方案，那就是在控制器构造函数中使用Closure来直接定义中间件。请注意，在使用这个方案的时候，确保你所使用的Laravel版本高于 5.3.4：
         *
         * except "showLoginForm", "login" 除了控制器的这两个方法以外，未登录的都跳转到登录页
         */
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return redirect('/login');
            }

//            dd($request->getPathInfo());

            $this->admin = Auth::user();
            $this->pageData['admin'] = $this->admin;
            $menuList = $this->getMenuList();
            foreach ($menuList as $key => $item) {
                if ($item['route'] == $request->getPathInfo()) {
                    $menuList[$key]['active'] = true;
                    break;
                }

                foreach ($item['subMenuList'] ?? [] as $subMenu) {
                    if ($subMenu['route'] == $request->getPathInfo()) {
                        $menuList[$key]['active'] = true;
                        break;
                    }
                }
            }

            $this->pageData['menuList'] = $menuList;

            return $next($request);
        })->except($this->notAllowLoginMethods);
    }

    private function getMenuList() {
        $menuList =  [
                [
                    'title' => '首页',
                    'route' => '/'
                ],
                [
                    'title' => '房源分类管理',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '分类列表',
                            'route' => '/roomCategory',
                        ],
                        [
                            'title' => '添加分类',
                            'route' => '/roomCategory/add',
                        ],
                    ]
                ],
                [
                    'title' => '房源管理',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '房源列表',
                            'route' => '/roomSource',
                        ],
                        [
                            'title' => '预约列表',
                            'route' => '/bespeak',
                        ],
                        [
                            'title' => '添加房源',
                            'route' => '/roomSource/add',
                        ],
                    ]
                ],
                [
                    'title' => '红包管理',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '红包配置',
                            'route' => '/redPack/config',
                        ],
                        [
                            'title' => '红包数据统计',
                            'route' => '/redPack/statistics',
                        ]
                    ]
                ],
                [
                    'title' => '微信用户管理',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '用户列表',
                            'route' => '/user',
                        ]
                    ]
                ],
                [
                    'title' => '客服管理',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '客服列表',
                            'route' => '/customService',
                        ]
                    ]
                ],
                [
                    'title' => '业务员管理',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '业务员列表',
                            'route' => '/salesman',
                        ]
                    ]
                ],
                [
                    'title' => '管理员管理',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '管理员列表',
                            'route' => '/admins',
                        ],
                        [
                            'title' => '管理组列表',
                            'route' => '/adminGroups',
                        ],
                    ]
                ],
                [
                    'title' => '系统设置',
                    'route' => '#',
                    'subMenuList' => [
                        [
                            'title' => '密码管理',
                            'route' => '/pwd',
                        ]
                    ]
                ],
            ];

        return $menuList;
    }
}