<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 14:59
 */

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index() {
        return view('index');
    }

}