<?php
use Workerman\Worker;
require_once __DIR__ . '/Workerman/Autoloader.php';
date_default_timezone_set('PRC');
$now = date("Y-m-d");
$search_type = '';
//$mysqli = new mysqli($hostname_conn, $username_conn, $password_conn, $database_conn);
// 创建一个Worker监听2346端口，使用websocket协议通讯
$ws_worker = new Worker("websocket://0.0.0.0:2346");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{
    // 向客户端发送hello $data
    $data1 = json_decode($data);

    $connection->send(is_object($data1));
    //$connection->send(is_array($data1));
    //$connection->send(is_string($data1));
};

// 运行worker
Worker::runAll();
?>