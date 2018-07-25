<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 14:59
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index() {
        var_dump(Auth::user());
        return view('index');
    }

}