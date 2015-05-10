<?php
require __DIR__.'/common.php';

global $allow;
if (substr($_SERVER['REMOTE_ADDR'], 0, 3) == '10.') {
    echo $_REQUEST['callback'], '({"stat":1});';
    exit;
}
$redis = redis();
if (in_array($_REQUEST['id'], $allow) and $redis->get('us~'.$_SERVER['REMOTE_ADDR']) === null) {
    $pipe = $redis->pipeline();
    $pipe->incr($_REQUEST['id']);
    $pipe->setex('us~'.$_SERVER['REMOTE_ADDR'], 1, time());
    $pipe->execute();
    echo $_REQUEST['callback'], '({"stat":0});';
    exit;
}
echo $_REQUEST['callback'], '({"stat":1});';
