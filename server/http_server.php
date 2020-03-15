<?php
// 需要在cli运行，不然会报错的
// httpserver 是基于server的
// 监听0.0.0.0 表示监听所有地址
$http = new swoole_http_server('0.0.0.0', 8811);

// $request 请求
// $response 响应
$http->on('request', function ($request, $response) {
//    var_dump($_GET);// 是获取不到的，要通过$request获取
    var_dump($request->get);// 只能在服务器看到，浏览器是看不到的

    // 设置cookie
    $response->cookie('singwa', '值', time() + 1800);
    var_dump($_COOKIE);
    // 如果要把数据放在浏览器，就要用end()这个方法,而且必须要是string
    $response->end("<h1>HTTPserver</h1>");
});
$http->start();