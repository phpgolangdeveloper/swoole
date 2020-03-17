<?php


// 创建内存表
$table = new swoole_table(1024);


// 内存表增加一列
$table->column('id', TYPE_INT, 4);
$table->column('name', TYPE_STRING, 64);
$table->column('age', TYPE_INT, 3);
$table->create();

// 增加一行记录
$table->set('lalala',
    ['id' => 1, 'name' => 'twj', 'age' => 18]
);

$a = $table->get('lalala');
print_r($a);