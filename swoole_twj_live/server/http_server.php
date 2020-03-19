<?php
// 需要在cli运行，不然会报错的
// httpserver 是基于server的
// 监听0.0.0.0 表示监听所有地址
$http = new swoole_http_server('0.0.0.0', 8811);

$http->set(
    [
        'enable_static_handler' => true,//开启静态文件请求处理功能，需配合 document_root 使用 默认 false
        'document_root' => '/home/wwwroot/default/twj/swoole/swoole_twj_live/public/static',//设置静态处理器的路径。类型为数组，默认不启用
        'worker_num' => 5,
    ]
);

$this->on('WorkerStart', function(swoole_server $server, $worker_id ) {

    define('APP_PATH',__DIR__.'/../application');
    require __DIR__.'/../thinkphp/base.php';
});

// 上面$htt->set()，如果它有静态资源，就不会再走后面的逻辑了
$http->on('request', function ($request, $response) {



    $response->cookie('singwa', '值', time() + 1800);
    $response->end("<h1>HTTPserver</h1>");

});
$http->start();