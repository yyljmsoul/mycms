<?php


namespace Addons\Qiniu\Providers;


use Addons\Qiniu\Expand\QiNiuAdapter;
use League\Flysystem\Filesystem;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var string $addonName
     */
    protected $addonName = 'Qiniu';

    /**
     * @var string $moduleNameLower
     */
    protected $addonNameLower = 'qiniu';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerStatic();
        $this->loadMigrationsFrom(addon_path($this->addonName, '/Database/Migrations'));

        $this->registerService();
    }


    /**
     * 注册服务
     * @return void
     */
    protected function registerService()
    {
        include addon_path('Qiniu', '/Expand/functions.php');

        app('filesystem')->extend('qiniu', function ($app, $config) {

            $adapter = new QiNiuAdapter(
                $config['qn_access'],
                $config['qn_secret'],
                $config['qn_bucket'],
            );

            return new Filesystem($adapter);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            addon_path($this->addonName, '/Config/config.php'), "filesystems.disks.{$this->addonNameLower}"
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->loadViewsFrom(addon_path($this->addonName, '/Resources/Views'), $this->addonNameLower);
    }

    /**
     * Register static.
     *
     * @return void
     */
    protected function registerStatic()
    {
        $this->publishes([
            addon_path($this->addonName, '/Resources/Static') => public_path('mycms/addons/' . $this->addonNameLower),
        ], 'addon_' . $this->addonNameLower);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }
}
