<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        print_r($_GET);
        echo 123;
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
