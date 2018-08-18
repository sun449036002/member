<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 20:17
 */

namespace App\Model;


class RoomSourceModel extends BaseModel
{
    protected $table = "room_source";

    /**
     * @param $columns
     * @param $where
     * @param array $order
     * @param array $group
     * @return object
     */
    public function getOne($columns, $where, $order = [], $group = []) {
        $row = parent::getOne($columns, $where, $order, $group);
        if (!empty($row->imgJson)) {
            $imgs = json_decode($row->imgJson);
            $row->cover = env("MEMBER_IMG_DOMAIN") . $imgs->cover ?? "";
            $row->imgs = $imgs->imgs ?? [];
            foreach ($row->imgs as $k => $img) {
                $row->imgs[$k] = env("MEMBER_IMG_DOMAIN") . $img;
            }
            unset($row->imgJson);
        }
        return $row;
    }
}