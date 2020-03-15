<?php
// 连接 swoole tcp 服务
$client = new swoole_client(SWOOLE_SOCK_TCP);

if (!$client->connect("127.0.0.1", 9501)) {
    echo "连接失败";
    exit;
}

// php cli 常量，我们swoole里面的一些服务，大部分都是在cli服务下运作的
fwrite(STDOUT,'请输入消息:');
$msg = trim(fgets(STDIN));// 获取用户输入的数据
// 把消息发送到tcp server服务器
$client->send($msg);

// 接受来自server 的数据
$result = $client->recv();

echo $result;





