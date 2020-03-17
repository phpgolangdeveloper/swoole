<?php

/***
 * 读取文件
 * __DIR__
 */
swoole_async_readfile(__DIR__.'/1.txt',function($filename,$fileContent) {
    echo "filename:".$filename.PHP_EOL; // PHP 中换行可以用 PHP_EOL 来替代，以提高代码的源代码级可移植性：
    echo "content:".$fileContent.PHP_EOL; // PHP 中换行可以用 PHP_EOL 来替代，以提高代码的源代码级可移植性：
});