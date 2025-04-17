<?php


namespace Expand\Swoole\reset;


use Illuminate\Support\Facades\Facade;

class SessionReset implements ResetInterface
{
    public $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function reset()
    {
        if ($this->app['session']) {

            $ref = new \ReflectionObject($this->app['session']);
            $drivers = $ref->getProperty('drivers');
            $drivers->setAccessible(true);

            $drivers->setValue($this->app['session'], []);
            $this->app->forgetInstance('session.store');
            Facade::clearResolvedInstance('session.store');

            if (isset($this->app['redirect'])) {
                /**@var Redirector $redirect */
                $redirect = $this->app['redirect'];
                $redirect->setSession($this->app->make('session.store'));
            }
        }

    }
}
