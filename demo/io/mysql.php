<?php
//
//class AysMysql
//{
//
//    public $dbSource = "";
//
//    public function __construct()
//    {
////        $this->dbSource = new Swoole\Mysql;
////        $this->dbConfig = [
////            'host' => "127.0.0.1",
////            'post' => 3306,
////            'user' => 'root',
////            'password' => 123456,
////            'database' => 'test',
////            'charset' => 'utf8',
////        ];
//        Co::set(['hook_flags' => SWOOLE_HOOK_TCP]);
//        $http = new swoole_http_server('0.0.0.0', 8811);
//        $http->set(['enable_coroutine' => false]);
//        $http->on('request', function ($request, $response) {
//            go(function(){
//                $this->aa();
//            });
//
//            $response->end("hahaha");
//        });
//        var_dump(123);
//        $http->start();
//    }
//
//    public function aa()
//    {
//        echo 1;
//        sleep(10);
//    }
//
//}
//
//
//new AysMysql();

$server = new Swoole\Http\Server("0.0.0.0", 8811);

$server->set([
//关闭内置协程
    'enable_coroutine' => false,
]);

$server->on("request", function ($request, $response) {
    if (1) {
        go(function () use ($response) {
            co::sleep(0.2);
            $response->header("Content-Type", "text/plain");
            $response->end("Hello World1\n");
        });
    } else {
        $response->header("Content-Type", "text/plain");
        $response->end("Hello World2\n");
    }
});

$server->start();