<?php
require __DIR__.'/common.php';
define('LIMIT', 100);

$redis = redis();
$keys = $redis->keys('us~*');
$ret = array('total' => count($keys), 'data' => array());
$pipe = $redis->pipeline();
if (count($keys) > LIMIT) {
    foreach (array_chunk($keys, LIMIT) as $g) {
        foreach ($redis->mget($g) as $addr) {
            if ($addr === null) continue;
            if (!isset($ret['data'][$addr])) $ret['data'][$addr] = 0;
            ++$ret['data'][$addr];
        }
    }
} else {
    foreach ($redis->mget($keys) as $addr) {
        if ($addr === null) continue;
        if (!isset($ret['data'][$addr])) $ret['data'][$addr] = 0;
        ++$ret['data'][$addr];
    }
}
arsort($ret['data']);
echo $_REQUEST['callback'], '(', json_encode($ret), ');';
