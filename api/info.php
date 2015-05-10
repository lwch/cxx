<?php
require __DIR__.'/common.php';
define('LIMIT', 1000);

$redis = redis();
$cur = 0;
$ret = array('total' => 0);
do {
    $scan = $redis->scan($cur, array('MATCH' => 'us~*', 'COUNT' => LIMIT));
    $ret['total'] += count($scan[1]);
    foreach ($redis->mget($scan[1]) as $addr) {
        if (!isset($ret['data'][$addr])) $ret['data'][$addr] = 0;
        ++$ret['data'][$addr];
    }
    $cur = $scan[0];
} while ($cur);
echo $_REQUEST['callback'], '(', json_encode($ret), ');';
