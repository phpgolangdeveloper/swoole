<?php

/***
 * 读取文件
 * __DIR__
 */
// $filename = __DIR__.'/1.txt'
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
// 1 swoole_async_readfile(__DIR__.'/1.txt' 读取这个文件
// 2 echo "start".PHP_EOL;
// 3 回调函数里面的
//echo "filename:".$filename.PHP_EOL; // PHP 中换行可以用 PHP_EOL 来替代，以提高代码的源代码级可移植性：
//echo "content:".$fileContent.PHP_EOL; // PHP 中换行可以用 PHP_EOL 来替代，以提高代码的源代码级可移植性：
