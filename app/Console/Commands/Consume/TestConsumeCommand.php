<?php
/**
 * Created by PhpStorm.
 * User: liangwenquan
 * Date: 2018/11/22
 * Time: 上午10:21
 */

namespace App\Console\Commands\Consume;


class TestConsumeCommand extends ConsumeInterface
{
    protected $signature = 'consume:test';

    protected $description = 'test kafka consume command';

    protected $queue = 'test_kafka';

    public function consume($data)
    {
        // TODO: Implement consume() method.
        var_dump($data);
        return self::SIG_CONTINUE;
    }
}