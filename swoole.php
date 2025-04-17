<?php

use Expand\Swoole\MySwoole;

require 'Expand/Swoole/Console.php';
require 'Expand/Swoole/Process.php';
require 'Expand/Swoole/MySwoole.php';


const ROOT_PATH = __DIR__;

$instance = MySwoole::getInstance();
$instance->run($argv);
