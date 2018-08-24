<?php
namespace App\Logic;
use App\Model\AdminModel;
use App\Model\BespeakModel;
use App\Model\RoomSourceModel;
use App\Model\UserModel;

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
            $userModel = new UserModel();
            $adminModel = new AdminModel();
            foreach ($list as $item) {
                $room = $roomSourceModel->getOne(['name'], ['id' => $item->roomId]);
                $item->roomSourceName = $room->name ?? "";

                $user = $userModel->getOne(['admin_id'], ['id' => $item->userId]);
                $admin = $adminModel->getOne(['name'], ['id' => $user->admin_id ?? 0]);
                $item->adminName = $admin->name ?? "";
            }
        }

        return $list;
    }

}