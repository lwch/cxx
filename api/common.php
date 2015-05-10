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
            foreach (explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']) as $ip) {
                $ip = trim($ip);
                if ($ip != 'unknown') {
                    $realip = $ip;
                    break;
                }
            }
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
