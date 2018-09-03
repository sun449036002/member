<?php
namespace App\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/22
 * Time: 20:18
 */
class UserModel extends BaseModel
{
    protected $table = "user";

    /**
     * 获取用户的全部信息
     * @param $userId
     * @return object
     */
    public function getUserAllInfo($userId) {
        $row = parent::getOne(["*"], ['id' => $userId]);
        $row->info = json_decode($row->user_json);
        $row->avatar_url = headImgUrl($row->avatar_url);
        return $row;
    }

    /**
     * 获取列表
     * @return array
     */
    public function getUserList() {
        return parent::getList(['*'], ['type' => 1]);
    }

    /**
     * 根据 openid 获取用户信息
     * @param $openid || $id
     * @return mixed
     */
    public function getUserinfoByOpenid($openid = '') {
        $fields = ['id',"username", "is_subscribe", "type", "uri", "avatar_url"];
        if (is_numeric($openid)) {
            $id = $openid;
            $row = $this->getOne($fields, ['id' => $id]);
        } else {
            $row = $this->getOne($fields, ['openid' => $openid]);
        }
        $user = [];
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $user[$key] = $val;
            }
        }
        return $user;
    }

}