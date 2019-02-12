<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 14:21
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;

class TestThree extends Command
{
    protected $signature = "test:cron3";

    public function handle() {
        $this->info($this->signature . ":执行时间:" . time());
        sleep(5);
        $this->info($this->signature . ":5秒后的结束时间:" . time());
    }
}