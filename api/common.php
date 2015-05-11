<?php
require __DIR__.'/../3rdParty/predis/autoload.php';

Predis\Autoloader::register();

function redis() {
    static $redis;
    if (empty($redis)) {
        $redis = new Predis\Client(array(
            'host' => $_ENV['REDIS_HOST'],
            'port' => $_ENV['REDIS_PORT'],
            'password' => $_ENV['REDIS_PASS']
        ));
    }
    return $redis;
}

function realip() {
    static $realip;
    if (empty($realip)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $cnt = 0;
            $forward = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ips = array();
            foreach ($forward as $ip) {
                $ip = trim($ip);
                if (substr($ip, 0, 3) == '10.') ++$cnt;
                if ($ip != 'unknown')
                    $ips[] = $ip;
            }
            if ($cnt != 1 or count($forward) != 2) $realip = '';
            else $realip = $ips[0];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    }
    return $realip;
}

$allow = array(
    'asm', 'c', 'cxx',
    'csharp', 'html', 'java',
    'js', 'lua', 'perl',
    'php', 'objc', 'python',
    'ruby', 'shell', 'vb',
    'shanghai', 'yueyu', 'putong',
    'kongju', 'other'
);
