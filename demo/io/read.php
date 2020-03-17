<?php

/***
 * 读取文件
 * __DIR__指向当前执行的PHP脚本所在的目录。
 */
$fileName = __DIR__.'/1.txt';
go(function() use ($fileName) {
    $result = Swoole\Coroutine\System::readFile($fileName);
    var_dump($result);
    echo "<hr />";
});

// 先执行
echo "start".PHP_EOL;

// 异步读取文件
// 场景顺序
// 1 go协程的方式去读取 __DIR__.'/1.txt' 这个文件
// 2 echo "start".PHP_EOL;
// 3 再执行回调函数里面的
