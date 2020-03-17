<?php

$process = new swoole_process(function(swoole_process $pro) {


}, true);
$pid = $process->start();
echo $pid. PHP_EOL;