<?php
require __DIR__.'/common.php';

global $allow;
$redis = redis();
if (in_array($_REQUEST['id'], $allow) and $redis->get('us~'.$_SERVER['REMOTE_ADDR']) === null) {
    $pipe = $redis->pipeline();
    $pipe->incr($_REQUEST['id']);
    $pipe->setex('us~'.$_SERVER['REMOTE_ADDR'], 1, time());
    $pipe->execute();
    echo '{"stat":0}';
    exit;
}
echo '{"stat":1}';
