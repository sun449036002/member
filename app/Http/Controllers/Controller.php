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

            $this->admin = Auth::user();
            $this->pageData['admin'] = $this->admin;

            return $next($request);
        })->except($this->notAllowLoginMethods);
    }
}