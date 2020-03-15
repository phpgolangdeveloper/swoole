<?php
//创建Server对象，监听 127.0.0.1:9501端口
$serv = new \swoole_server("0.0.0.0", 9501);

$serv->set([
    'worker_num' => 4,// 四个进程
    'max_request' => 10000,
]);

//监听连接进入事件
/***
 * $fd 客户端连接的唯一标识
 * $reactor_id 线程id
 */
$serv->on('connect', function ($serv, $fd,$reactor_id) {
    echo "客户端发来的: reactor_id:{$reactor_id} - fd:{$fd}  Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "我是服务器发送出去的: reactor_id:{$reactor_id} - fd:{$fd}data:" . $data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "结束了，关闭了: Close.{$fd}\n";
});

//启动服务器
$serv->start();