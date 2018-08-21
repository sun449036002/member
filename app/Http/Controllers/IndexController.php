<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 14:59
 */

namespace App\Http\Controllers;

use App\Consts\CacheConst;
use App\Model\BespeakModel;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index() {
        $userModel = new UserModel();
        //总的用户关注数量
        $total = $userModel->where("type", 1)->count();

        //今天关注用户数量
        $cacheKey = sprintf(CacheConst::TODAY_SUBSCRIBE_NUM, date("Ymd"));
        $todayTotal = intval(Redis::get($cacheKey));

        //今日的预约单子次
        $bespeakModel = new BespeakModel();
        $this->pageData['todayTotalBespeakNum'] = $bespeakModel->where("createTime", ">=", strtotime(date("Y-m-d")))
            ->where("createTime", "<=", strtotime(date("Y-m-d 23:59:59")))->count();

        //未完成的预约清单列表
        $this->pageData['bespeakList'] = $bespeakModel->getList(['*'], ['status' => 0], ['time']);

        $this->pageData['total'] = $total;
        $this->pageData['todayTotal'] = $todayTotal;
        return view('index', $this->pageData);
    }

}