<?php

//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new \swoole_websocket_server("0.0.0.0", 9502);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {
    var_dump($request->fd, $request->get, $request->server);
    $ws->push($request->fd, "你好,客户端已经成功和我握手，现在可以通讯啦\n");
});

$ws->set(
    [
        'worker_num' => 2,
        'task_worker_num' => 2,
    ]
);


//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    echo "客户端发来的消息: {$frame->data}\n";
    $ws->push($frame->fd, "服务端向客户端发的消息: {$frame->data}");
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "关闭事件-{$fd} is closed\n";
});

$ws->start();