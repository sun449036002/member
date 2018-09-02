<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2
 * Time: 12:23
 */

namespace App\Logic;


use App\Model\HubModel;

class HubLogic extends BaseLogic
{
    /**
     * 获取所有菜单列表 包括对应的子栏目
     * @return array
     */
    public function getMenuList() {
        //一级栏目
        $model = new HubModel();
        $list = $model->getHubList();

        if (!empty($list)) {
            foreach ($list as $key => $hub) {
                $list[$key]->sublist = $model->getHubList($hub->id);
            }
        }

        return $list;
    }


    /**
     * 生成微信公众号可用的菜单按钮数组
     * @return array
     */
    public function getMenuButtons() {
        $list = $this->getMenuList();

        /*$buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];*/
        $buttons = [];
        if (!empty($list)) {
            foreach ($list as $item) {
                $subs = [];
                if (!empty($item->sublist)) {
                    foreach ($item->sublist as $subItem) {
                        $subs[] = [
                            'type' => "view",
                            'name' => $subItem->name,
                            'url' => $subItem->url ?: env('APP_URL')
                        ];
                    }
                }
                if (!empty($subs)) {
                    $buttons[$item->id] = [
                        'name' => $item->name,
                        'sub_button' => $subs
                    ];
                } else {
                    $buttons[$item->id] = [
                        'type' => "view",
                        'name' => $item->name,
                        'url' => $item->url ?: env('APP_URL')
                    ];
                }
            }
        }

        return $buttons;
    }
}