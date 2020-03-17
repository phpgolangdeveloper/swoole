<?php

class AysMysql
{

    public $dbSource = "";

    public function __construct()
    {
//        $this->dbSource = new Swoole\Mysql;
//        $this->dbConfig = [
//            'host' => "127.0.0.1",
//            'post' => 3306,
//            'user' => 'root',
//            'password' => 123456,
//            'database' => 'test',
//            'charset' => 'utf8',
//        ];
        Co::set(['hook_flags' => SWOOLE_HOOK_TCP]);
        $http = new swoole_http_server('0.0.0.0', 8811);
        $http->set(['enable_coroutine' => true]);
        $http->on('request', function ($request, $response) {
            $this->aa();

            $response->end("hahaha");
        });
        var_dump(123);
        $http->start();
    }

    public function aa()
    {
        sleep(10);
    }

}


new AysMysql();