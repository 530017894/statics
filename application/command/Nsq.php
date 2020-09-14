<?php


namespace app\command;


use app\admin\service\Es;
use OkStuff\PhpNsq\Stream\Message;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Nsq extends \OkStuff\PhpNsq\Cmd\Subscribe
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $phpnsq = self::$phpnsq;
        $phpnsq->setTopic($input->getArgument("topic"))
            ->setChannel($input->getArgument("channel"))
            ->subscribe($this, function (Message $message) use ($phpnsq, $output) {
                $phpnsq->getLogger()->info("READ", $message->toArray());
                // todo 插入到es
                Es::create($message->toArray());
            });
        //excuted every five seconds.
        $this->addPeriodicTimer(5, function () use ($output) {
            $memory    = memory_get_usage() / 1024;
            $formatted = number_format($memory, 3) . 'K';
            $output->writeln(date("Y-m-d H:i:s") . " ############ Current memory usage: {$formatted} ############");
        });
        $this->runLoop();
    }
}