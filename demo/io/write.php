<?php


$filename = './wirte.txt';
go(function () use ($filename) {
    echo 'end';
    $bool = Swoole\Coroutine\System::writeFile($filename, '哈哈哈哈', FILE_APPEND);
    var_dump($bool);
    echo "<hr  />";
});
echo 'start';