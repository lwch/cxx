<?php
echo '__________ SERVER __________', "\n";
var_dump($_SERVER);
echo '__________ REQUEST _________', "\n";
var_dump($_REQUEST);
function realip() {
    static $realip;
    if (empty($realip)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $cnt = 0;
            $forward = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($forward as $ip) {
                $ip = trim($ip);
                if (substr($ip, 0, 3) == '10.') ++$cnt;
                if ($ip != 'unknown') {
                    $realip = $ip;
                    break;
                }
            }
            if ($cnt != 1 or count($forward) != 2) $realip = '';
            var_dump($cnt, $forward, $realip);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    }
    return $realip;
}
realip();
