<?php
require __DIR__.'/common.php';
define('LIMIT', 100);

$redis = redis();
$keys = $redis->keys('us~*');
$ret = array('total' => count($keys), 'data' => array());
echo $_REQUEST['callback'], '(', json_encode($ret), ');';exit;
$tmp = array();
while (count(keys)) {
    $tmp[] = array_pop($keys);
    if (count($tmp) >= LIMIT) {
        foreach ($redis->mget($tmp) as $addr) {
            if (!isset($ret['data'][$addr])) $ret['data'][$addr] = 0;
            ++$ret['data'][$addr];
        }
        $tmp = array();
    }
}
if (count($tmp)) {
    foreach ($redis->mget($tmp) as $addr) {
        if (!isset($ret['data'][$addr])) $ret['data'][$addr] = 0;
        ++$ret['data'][$addr];
    }
}
ksort($ret['data']);
echo $_REQUEST['callback'], '(', json_encode($ret), ');';
