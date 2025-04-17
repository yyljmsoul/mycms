<?php


namespace Expand\Swoole;


trait Console
{
    public function info($msg)
    {
        echo "\033[32m{$msg}";
        echo "\033[0m";
        echo "\n";
    }
}
