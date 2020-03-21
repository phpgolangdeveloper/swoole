<?php
// 需要在cli运行，不然会报错的
// httpserver 是基于server的
// 监听0.0.0.0 表示监听所有地址
$http = new swoole_http_server('0.0.0.0', 8811);

$http->set(
    [
        'enable_static_handler' => true,//开启静态文件请求处理功能，需配合 document_root 使用 默认 false
        'document_root' => '/home/wwwroot/default/twj/swoole/swoole_twj_live/public/static',//设置静态处理器的路径。类型为数组，默认不启用
        'worker_num' => 5, // 五个worker进程，这里有多少个就会有多少个WorkerStart回调
    ]
);

$http->on('WorkerStart', function (swoole_server $server, $worker_id) {
    // 在worker进程中把相关代码加载进来
    define('APP_PATH', __DIR__ . '/../application');
    require __DIR__ . '/../thinkphp/base.php';
});

// 上面$htt->set()，如果它有静态资源，就不会再走后面的逻辑了
$http->on('request', function ($request, $response) use ($http) {
//    header('Content-Type: text/html; charset=utf-8'); //网页编码
    $_SERVER = [];
    if (isset($request->server)) {
        foreach ($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if (isset($request->header)) {
        foreach ($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    $_GET = [];
    if (isset($request->get)) {
        foreach ($request->get as $k => $v) {
            $_GET[strtoupper($k)] = $v;
        }
    }
    $_POST = [];
    if (isset($request->post)) {
        foreach ($request->post as $k => $v) {
            $_POST[strtoupper($k)] = $v;
        }
    }
    ob_start();
    try {
        \think\Container::get('app', [APP_PATH])
            ->run()
            ->send();
    } catch (\Exception $e) {

    }
    $res = ob_get_contents();
    ob_end_clean();
    $response->end($res);
    $http->close();

});
$http->start();