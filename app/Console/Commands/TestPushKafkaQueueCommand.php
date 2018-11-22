<?php
/**
 * Created by PhpStorm.
 * User: liangwenquan
 * Date: 2018/11/22
 * Time: 上午10:53
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Library\Service\Kafka;

class TestPushKafkaQueueCommand extends Command
{
    const TEST_QUEUE = 'test_kafka';

    protected $signature = 'consume:push';

    protected $description = 'test push msg into kafka queue';

    public function handle()
    {
        for ($i = 0; $i < 100; $i++) {
            Kafka::getInstance()->pub(self::TEST_QUEUE, $i);
        }

        return true;
    }

}