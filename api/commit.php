<?php
require __DIR__.'/common.php';

global $allow;
$redis = redis();
$ip = ip2long($_SERVER['REMOTE_ADDR']);
if (($ip >> 24) & 0xFF == 10)
    exit;
if (in_array($_REQUEST['id'], $allow) and $redis->get('us~'.$_SERVER['REMOTE_ADDR']) === null) {
    $pipe = $redis->pipeline();
    $pipe->incr($_REQUEST['id']);
    $pipe->setex('us~'.$_SERVER['REMOTE_ADDR'], 1, time());
    $pipe->execute();
    echo $_REQUEST['callback'], '({"stat":0});';
    exit;
}
echo $_REQUEST['callback'], '({"stat":1});';
