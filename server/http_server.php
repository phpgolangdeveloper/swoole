<?php
// 需要在cli运行，不然会报错的
// httpserver 是基于server的
// 监听0.0.0.0 表示监听所有地址
$http = new swoole_http_server('0.0.0.0', 8811);

$http->set(
    [
        'enable_static_handler' => true,//开启静态文件请求处理功能，需配合 document_root 使用 默认 false
        'document_root' => '/home/wwwroot/default/twj/swoole/data',//设置静态处理器的路径。类型为数组，默认不启用
    ]
);
// 上面$htt->set()，如果它有静态资源，就不会再走后面的逻辑了


// $request 请求
// $response 响应
$http->on('request', function ($request, $response) {
//    var_dump($_GET);// 是获取不到的，要通过$request获取
//    var_dump($request->get);// 只能在服务器看到，浏览器是看不到的

    $content = [
        'get' => $request->get,
        'post' => $request->post,
        'header' => $request->header,
        'date:' => date('Y-M-D H:i:s'),
    ];
    $filename = './access.log';
    go(function () use ($filename, $content) {
        $bool = Swoole\Coroutine\System::writeFile($filename, json_encode($content ), FILE_APPEND);
        var_dump($bool);
    });


    // 设置cookie
    $response->cookie('singwa', '值', time() + 1800);

    // 如果要把数据放在浏览器，就要用end()这个方法,而且必须要是string
    $response->end("<h1>HTTPserver</h1>");

});
$http->start();