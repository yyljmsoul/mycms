<?php


namespace Expand\Swoole;


trait Process
{
    public function read()
    {
        return explode(",", file_get_contents($this->config['pid_file']));
    }

    public function write($content)
    {
        file_put_contents($this->config['pid_file'],$content);
    }

}
