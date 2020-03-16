<?php


class Ws
{

    const HOST = '0.0.0.0';
    const PORT = 8812;
    public $ws = null;

    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server("0.0.0.0", 8812);
        $this->ws->set(
            [
                'worker_num' => 2,
                'task_worker_num' => 2,
            ]
        );
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->on('close', [$this, 'onClose']);
        $this->ws->start();
    }

    public function onOpen($ws, $request)
    {
        var_dump($request->fd . "\n");
    }

    public function onMessage($ws, $frame)
    {
        echo 'ser-push-message:' . $frame->data . "\n";
        // todo::
        $data = [
            'task' => 1,
            'fd' => $frame->fd,

        ];
        $ws->task($data);
        $ws->push($frame->fd, 'server-push:' . date('Y-M-D H:i:s') . "\n");
    }

    /***
     * @param $ws http 或者 ws的对象
     * @param $task_id 任务ID
     * @param $workerId
     * @param $data $ws->task($data);投递的任务
     */
    public function onTask($serv, $taskId, $workerId, $data)
    {
        print_r($data);
        sleep(10);
        return 'on task finish';// 返回内容告诉worker进程
    }

    /***
     * @param $serv
     * @param $taskId
     * @param $data onTask的返回值
     */
    public function onFinish($serv, $taskId, $data)
    {
        echo 'taskId:' . $taskId . "\n";
        echo 'finish-data-sucess:' . $data . "\n";
    }

    public function onClose($ws, $fd)
    {
        echo 'clientid:' . $fd . "\n";
    }
}

$obj = new Ws();