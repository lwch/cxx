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

$allow = array(
    'asm', 'c', 'cxx',
    'csharp', 'java', 'js',
    'lua', 'perl', 'php',
    'objc', 'python', 'ruby',
    'shell',
    'shanghai', 'yueyu', 'putong',
    'kongju', 'other'
);
