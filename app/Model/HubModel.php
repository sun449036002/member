<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/28
 * Time: 15:59
 */

namespace App\Model;


class HubModel extends BaseModel
{
    protected $table = "hubs";

    private $columns = ['*'];

    public function getHubList($pid = 0) {
        $order = ["order", "DESC"];
         return $this->getList($this->columns, ['pid' => $pid, 'isDel' => 0], $order);
    }
}