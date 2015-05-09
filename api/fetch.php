<?php
require __DIR__.'/common.php';

global $allow;
$ret = array();
$redis = redis();
foreach ($allow as $key) {
    $n = $redis->get($key);
    if ($n === null) $n = 0;
    $ret[$key] = strval($n);
}
echo json_encode($ret);
