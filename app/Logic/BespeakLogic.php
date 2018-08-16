<?php
namespace App\Logic;
use App\Model\BespeakModel;
use App\Model\RoomSourceModel;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 14:38
 */
class BespeakLogic extends BaseLogic
{
    public function getBespeakList() {
        $list = (new BespeakModel())->getList(['*']);
        if (!empty($list)) {
            $roomSourceModel = new RoomSourceModel();
            foreach ($list as $item) {
                $room = $roomSourceModel->getOne(['name'], ['id' => $item->roomId]);
                $item->roomSourceName = $room->name ?? "";
            }
        }

        return $list;
    }

}