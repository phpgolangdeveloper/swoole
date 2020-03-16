<?php

$server = new Swoole\WebSocket\Server("0.0.0.0", 8810);

// 监听websocket连接打开事件
$server->on('open','onOpen');
function onOpen($server,$server, $request) {
    print_r($request->fd);// 来自那个客户端的请求
};

// 监听ws消息事件
$server->on('message', function (Swoole\WebSocket\Server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "发送消息给客户端：");
});

// $fd  需要关闭的客户端
$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();