<?php

if (!defined('ROOT_PATH')) {

    define("ROOT_PATH", str_replace("Expand/Swoole", "", __DIR__));
}

return [
    'host' => '127.0.0.1',
    'port' => 1215,
    'worker_num' => swoole_cpu_num(),
    'max_request' => 2000,
    'pid_file' => ROOT_PATH . "/storage/swoole.pid",
    'resets' => [
        Expand\Swoole\reset\SessionReset::class,
        Expand\Swoole\reset\AuthReset::class,
    ],
    'reload_async' => true,
    'max_wait_time' => 30,
];
