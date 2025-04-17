<?php


namespace Expand\Swoole\reset;


use Illuminate\Support\Facades\Facade;

class AuthReset implements ResetInterface
{
    public $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @throws \ReflectionException
     */
    public function reset()
    {
        if ($this->app['auth']) {

            $ref = new \ReflectionObject($this->app['auth']);

            $guards = $ref->hasProperty('guards') ? $ref->getProperty('guards') : $ref->getProperty('drivers');
            $guards->setAccessible(true);

            $guards->setValue($this->app['auth'], []);
            $this->app->forgetInstance('auth.driver');
            Facade::clearResolvedInstance('auth.driver');
        }
    }
}
