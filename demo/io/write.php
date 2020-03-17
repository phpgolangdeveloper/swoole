<?php

go(function () {
    a(); // 只新增了一行代码
    echo "hello go1 \n";
});

echo "hello main \n";

go(function () {
    echo "hello go2 \n";
});

function a() {
    sleep(10);
}
//
//
//$filename = './wirte.txt';
//go(function () use ($filename) {
//    sleep(5);
//    echo "end\n";
//    $bool = Swoole\Coroutine\System::writeFile($filename, '哈哈哈哈', FILE_APPEND);
//    var_dump($bool);
//});
//echo "\nstart";