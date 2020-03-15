<?php

//创建Server对象，监听 127.0.0.1:9502端口，类型为SWOOLE_SOCK_UDP
// SWOOLE_PROCESS使用进程模式，业务代码在 Worker 进程中执行
//SWOOLE_SOCK_UDP创建 udp socket
$serv = new Swoole\Server("127.0.0.1", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);


$serv->set([
    'worker_num' => 4,// 四个进程
    'max_request' => 10000,
]);

//监听数据接收事件
//$clientInfo 是客户端的相关信息，是一个数组，有客户端的 IP 和端口等内容
//Packet 是onPacket事件 接收到 UDP 数据包时回调此函数，发生在 worker 进程中。
$serv->on('Packet', function ($serv, $data, $clientInfo) {
    // sendto向任意的客户端 IP:PORT 发送 UDP 数据包。
    $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server ".$data);
    var_dump($clientInfo);
/*
    $clientInfo
    array(4) {
      ["server_socket"]=>
      int(3)
      ["server_port"]=>
      int(9502)
      ["address"]=>
      string(9) "127.0.0.1"
      ["port"]=>
      int(48065)
    }
*/
});

//启动服务器
$serv->start();