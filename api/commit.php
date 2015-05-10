<?php
require __DIR__.'/common.php';

global $allow;
$redis = redis();
$ip = realip();
if (in_array($_REQUEST['id'], $allow) and $redis->get('us~'.$ip) === null) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'ip.taobao.com/service/getIpInfo.php?ip='.$ip);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $val = 'unknown';
    $ret = curl_exec($curl);
    if ($ret !== false) {
        $ret = json_decode($ret, true);
        if ($ret['code'] == 0) {
            $data = $ret['data'];
            $val = $data['country'].' --- '.$data['area'].' / '.$data['region'].' / '.$data['city'];
        }
    }
    curl_close($curl);
    $pipe = $redis->pipeline();
    $pipe->incr($_REQUEST['id']);
    $pipe->setex('us~'.$ip, 3600, $val);
    $pipe->execute();
    echo $_REQUEST['callback'], '({"stat":0});';
    exit;
}
echo $_REQUEST['callback'], '({"stat":1});';
