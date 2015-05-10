<?php
require __DIR__.'/common.php';

global $allow;
$redis = redis();
$ip = realip();
if (in_array($_REQUEST['id'], $allow) and $redis->get('us~'.$ip) === null) {
    $pipe = $redis->pipeline();
    $pipe->incr($_REQUEST['id']);
    $pipe->setex('us~'.$ip, 1, time());
    $pipe->execute();
    echo $_REQUEST['callback'], '({"stat":0});';
    exit;
}
echo $_REQUEST['callback'], '({"stat":1});';
