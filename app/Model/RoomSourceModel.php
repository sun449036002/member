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

            //封面
            $row->cover = $imgs->cover ?? "";
            $row->originCover = $row->cover;
            $row->cover = empty($imgs->cover) ? "" : env("MEMBER_IMG_DOMAIN") . $imgs->cover;
            //详情轮播图
            $row->imgs = $imgs->imgs ?? [];
            $row->originImgs = $row->imgs;
            foreach ($row->imgs as $k => $img) {
                $row->imgs[$k] = env("MEMBER_IMG_DOMAIN") . $img;
            }
            //户型图
            $row->houseTypeImgs = $imgs->houseTypeImgs ?? [];
            $row->originHouseTypeImgs = $row->houseTypeImgs;
            foreach ($row->houseTypeImgs as $k => $img) {
                $row->houseTypeImgs[$k] = env("MEMBER_IMG_DOMAIN") . $img;
            }

            unset($row->imgJson);
        }
        return $row;
    }
}