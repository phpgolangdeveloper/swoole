<?php

class AysMysql
{

    public $dbSource = "";

    public function __construct()
    {
        $this->dbSource = new Swoole\Mysql;
        $this->dbConfig = [
            'host' => "127.0.0.1",
            'post' => 3306,
            'user' => 'root',
            'password' => 123456,
            'database' => 'test',
            'charset' => 'utf8',
        ];

    }

}


new AysMysql();
