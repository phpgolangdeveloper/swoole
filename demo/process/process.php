<?php
// process.php 这个整个是个主进程

$process = new swoole_process(function(swoole_process $pro) {

    // 类似在linux终端里面执行一个命令 类似 php redis.php
    $pro->exec('/usr/local/php/bin/php',[
        __DIR__.'/../server/http_server.php'
    ]);// 执行一个外部程序

}, false);// true 第二个参数为true,则不会打印在终端了,放管道里面去了
$pid = $process->start();// 创建一个子进程，返回子进程ID
echo $pid. PHP_EOL;
swoole_process::wait();// 回收子进程