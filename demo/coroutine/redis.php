<?php

$http = new swoole_http_server('0.0.0.0', 8813);
$http->on('request', function ($request, $response) {


    // 获取redis里面的key内容。然后输出浏览器
    // 这些都是同步代码，然后实现了异步IO
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $val = $redis->get($request->get['a']);
    // swoole有一个特性
    // 比如上面连接redis 如果下面再连接mysql 那么他们的总体时间公式
    // 公式是 总消耗时间= max(redis, mysql)

    $response->end($val);
});
$http->start();

//