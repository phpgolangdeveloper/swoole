<?php


$redis = new new Swoole\Coroutine\Redis();
$redis->connect('127.0.0.', 6379);
$redis->get('swoole');