<?php
$workers = [];
$urls = [
    'http://baidu.com',
    'http://sina.com.cn',
    'http://qq.com',
    'http://baidu.com?search=singwa',
    'http://baidu.com?search=singwa2',
    'http://baidu.com?search=imooc',
];

for ($i = 0; $i < 6; $i++) {

    // 子进程
    $process = new swoole_process(function (swoole_process $worker) use ($i, $urls) {
        $content = curlData($urls[$i]);
        echo $content . PHP_EOL;
    }, true);
    $pid = $process->start();
    $workers[$pid] = $process;
}

// 获取管道的东西
foreach ($workers as $process) {
    echo $process->read();
}


// 模拟请求url 请求耗时为1秒每个
function curlData($url)
{
    sleep(1);
    return $url . 'success' . PHP_EOL;
}