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

Auth::routes();

/**
 * 资源类路由
 */
Route::resources([
    //管理员管理
    "admins" => 'AdminController',

    //管理组管理
    'adminGroups' => 'AdminGroupController',

    //权限管理
    'authority' => 'AuthorityController',

    //广告管理
    'ads' => 'AdsController',

    //地域管理
    'area' => 'AreaController',

    //户型管理
    'houseType' => 'HouseTypeController',

    //房源标签
    'roomTag' => 'RoomTagController',

    //客服管理
    'customService' => 'CustomServiceController',
]);


Route::get('/', "IndexController@index");

//重置管理员密码
Route::post('/admins/resetPwd', "AdminController@resetPwd");

Route::post("/adminResourceTransfer", "AdminController@resourceTransfer");

//图片上传
Route::post("/img/upload", "ImgController@upload");

//栏目管理
Route::get("/hub", "HubController@index");
Route::get("/hub/edit", "HubController@edit");
Route::post("/hub/doAdd", "HubController@doAdd");
Route::post("/hub/doEdit", "HubController@doEdit");
Route::post("/hub/del", "HubController@del");

//房源分类
Route::get("/roomCategory", "RoomCategoryController@index");
Route::get("/roomCategory/add", "RoomCategoryController@add");
Route::post("/roomCategory/doAdd", "RoomCategoryController@doAdd");
Route::get("/roomCategory/edit", "RoomCategoryController@edit");
Route::post("/roomCategory/doEdit", "RoomCategoryController@doEdit");
Route::post("/roomCategory/del", "RoomCategoryController@del");


//房源
Route::get("/roomSource", "RoomSourceController@index");
Route::get("/roomSource/add", "RoomSourceController@add");
Route::post("/roomSource/doAdd", "RoomSourceController@doAdd");
Route::get("/roomSource/edit", "RoomSourceController@edit");
Route::post("/roomSource/doEdit", "RoomSourceController@doEdit");
Route::post("/roomSource/del", "RoomSourceController@del");
Route::get("/roomSource/checkSameName", "RoomSourceController@checkSameName");
Route::get("/brokerList", "RoomSourceController@brokerList");

//预约管理
Route::get("/bespeak", "RoomSourceController@bespeakList");
Route::get("/bespeak/change", "RoomSourceController@bespeakChange");

//微信用户管理
Route::get("/user", "UserController@index");
Route::get("/user/detail", "UserController@detail");
Route::post("/user/lock", "UserController@lock");
Route::post("/user/changeAdminId", "UserController@changeAdminId");

//红包配置
Route::get("/redPack/config", "RedPackController@config");
Route::post("/redPack/saveConfig", "RedPackController@saveConfig");
Route::get("/redPack/cashBack", "RedPackController@cashBack");
Route::get("/redPack/cashBackDetail", "RedPackController@cashBackDetail");
Route::get("/redPack/statistics", "RedPackController@statistics");
Route::get("/redPack/withdraw", "RedPackController@withdraw");
Route::get("/redPack/withdrawDetail", "RedPackController@withdrawDetail");
Route::post("/redPack/withdrawExamine", "RedPackController@withdrawExamine");

//红包返现审核通过
Route::post("/redPack/cashBackExamine", "RedPackController@cashBackExamine");

//系统管理
Route::get("/system/aboutUs", "SystemController@aboutUs");
Route::post("/system/saveAboutUs", "SystemController@saveAboutUs");
