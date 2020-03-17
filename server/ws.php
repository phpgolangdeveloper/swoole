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
            // task_worker_num 配置 Task 进程的数量。【默认值：未配置则不启动 task】
            // worker_num 设置启动的 Worker 进程数。【默认值：CPU 核数】
            [
                'worker_num' => 2,
                'task_worker_num' => 2,// 配置此参数后将会启用 task 功能。所以 Server 务必要注册 onTask、onFinish 2 个事件回调函数。如果没有注册，服务器程序将无法启动。
            ]
        );
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->on('close', [$this, 'onClose']);
        $this->ws->start();
    }

    /***
     * 握手
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd . "\n");
        if ($request->fd == 1) {
            // 每2秒执行
            swoole_timer_tick(2000, function ($timer_id) {
                echo "2s:timerId:{$timer_id} \n";
            });
        }
    }

    public function onMessage($ws, $frame)
    {
        echo 'ser-push-message:' . $frame->data . "\n";
        // todo::
        $data = [
            'task' => 1,
            'fd' => $frame->fd,

        ];
//        $ws->task($data);// 投递异步耗时任务

        swoole_timer_after(5000, function() use($ws, $frame) {
            echo "5s-after\n";
            $ws->push($frame->fd, 'server-time-after:' . date('Y-M-D H:i:s') . "\n");
        });

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