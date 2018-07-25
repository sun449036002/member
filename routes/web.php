<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use \Illuminate\Support\Facades\Route;

Route::get('/', "IndexController@index");
Route::get("/login", "Auth\LoginController@login");
Route::post("/doLogin", "Auth\LoginController@doLogin");

//微信自定义菜单
Route::get("/weixin/custom-menu", "CustomMenuController@index");
Route::post("/weixin/custom-menu-create", "CustomMenuController@create");
Route::post("/weixin/custom-menu-del", "CustomMenuController@del");


