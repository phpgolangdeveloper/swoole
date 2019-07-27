<?php

//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new \swoole_websocket_server("0.0.0.0", 9502);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {
    var_dump($request->fd, $request->get, $request->server);

    if ($data = json_decode(file_get_contents('./push_data.txt'),true)) {
        $data = array_merge($data,[['push_id' => $request->fd,'ip' => $request->server['remote_addr']]]);
    } else {
        $data[] = ['push_id' => $request->fd,'ip' => $request->server['remote_addr']];
    }
    $json_data = json_encode($data,true);
    file_put_contents('./push_data.txt',$json_data);
    $ws->push($request->fd, "你好,客户端已经成功和我握手，现在可以通讯啦\n");
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    echo "客户端发来的消息: {$frame->data}\n";
    $data = file_get_contents('./push_data.txt');
    if ($data_array = json_decode($data,true)) {
        foreach ($data_array as $fd) {
            $ws->push($fd['push_id'], "{$frame->data}");
        }
    }
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "关闭事件-{$fd} is closed\n";
});

$ws->start();