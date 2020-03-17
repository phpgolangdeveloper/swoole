<?php


$filename = './wirte.txt';
go(function () use ($filename) {
    sleep(5);
    echo "end\n";
    $bool = Swoole\Coroutine\System::writeFile($filename, '哈哈哈哈', FILE_APPEND);
    var_dump($bool);
});
echo "\nstart";