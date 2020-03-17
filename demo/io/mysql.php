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
        Co\run(function () {
            go(function () {
                var_dump(1);
            });
        });
        var_dump(2);
    }

}
new mysqli();