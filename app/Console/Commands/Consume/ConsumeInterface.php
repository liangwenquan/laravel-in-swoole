<?php
/**
 * Created by PhpStorm.
 * User: liangwenquan
 * Date: 2018/11/22
 * Time: 上午10:05
 */

namespace App\Console\Commands\Consume;

use Illuminate\Console\Command;
use App\Library\Service\Kafka;
use App\Library\Log\Log;

abstract class ConsumeInterface extends Command
{
    const SIG_TERMINATE = 0; //false
    const SIG_CONTINUE = 1; //true

    /**
     * @var \Kafka
     */
    protected $kafka;

    protected $queue;

    //阈值设置较大，因为 kafka consumer 的启动和停止会引发 partition re-balance，有几秒阻塞
    protected $maxExecuteTime = 3600 * 8;
    protected $maxConsumeCount = 1000000;

    /**
     * 消息过期时间，过期的消息将丢弃掉
     * @var int
     */
    protected $expire = 0;


    protected $debug = 0;


    /**
     * @var string kafka consumer group
     */
    protected $consumer_group;

    /**
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        ini_set('display_errors', 1);

        $this->init();

        $start = time();
        $count = 0;
        $this->maxExecuteTime += rand(10, 100);

        $this->line('starting...');

        $this->consumer_group = $this->consumer_group ?: $this->queue.'/default';
        $consumer = $this->kafka->getConsumerClient([$this->queue], $this->consumer_group, Kafka::RESTORE_OFFSET_LARGEST);
        while (true) {
            try {
                $message = $consumer->consume(10 * 1000);
                if (!$this->kafka->checkMessage($message, $this->expire)) {
                    $this->warn('message invalid '.\json_encode($message));
                    continue;
                }

                $this->line('receive msg: '.\json_encode($message));
                Log::getLogger('consume_'.str_replace('/', '_', $this->consumer_group))->info('', ['message' => $message]);
                $sig = $this->consume($message->payload);

                $count++;
            } catch (\Exception $e) {
                Log::getLogger('exception')->error($e->getMessage(), ['e' => $e]);
                continue;
            } catch (\Error $e) {
                Log::getLogger('exception')->error($e->getMessage(), ['e' => $e]);
                continue;
            }

            if ($sig === self::SIG_TERMINATE) {
                $this->error('command '.$this->cmd.' terminated');
                break;
            }

            if ($this->maxExecuteTime && $start + $this->maxExecuteTime < time()) {
                $this->line('max execute time ' . $this->maxExecuteTime . ' achieved');
                break;
            }

            if ($count >= $this->maxConsumeCount) {
                $this->line('max consume count ' . $this->maxConsumeCount . ' achieved');
                break;
            }
        }
        return true;
    }

    /**
     * @throws \Exception
     */
    protected function init()
    {
        if (!$this->queue) {
            throw new \Exception('error queue name');
        }

        $this->kafka = Kafka::getInstance();
    }

    abstract protected function consume($data);
}