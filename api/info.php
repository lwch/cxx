<?php
require __DIR__.'/common.php';
define('LIMIT', 100);

$redis = redis();
$keys = $redis->keys('us~*');
$ret = array('total' => count($keys), 'data' => array());
$pipe = $redis->pipeline();
$c = 0;
while (count(keys)) {
    $pipe->get(array_pop($keys));
    file_put_contents('abc', $c."\n", FILE_APPEND);
    if (++$c % LIMIT == 0) {
        foreach ($pipe->execute() as $addr) {
            if ($addr === null) continue;
            if (!isset($ret['data'][$addr])) $ret['data'][$addr] = 0;
            ++$ret['data'][$addr];
        }
        $pipe = $redis->pipeline();
    }
}
echo $_REQUEST['callback'], '(', json_encode($ret), ');';exit;
if (count($tmp)) {
    $r = call_user_func_array(array($redis, 'mget'), $tmp);
    foreach ($r as $addr) {
        if (!isset($ret['data'][$addr])) $ret['data'][$addr] = 0;
        ++$ret['data'][$addr];
    }
}
ksort($ret['data']);
echo $_REQUEST['callback'], '(', json_encode($ret), ');';
