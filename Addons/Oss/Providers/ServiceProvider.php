<?php


namespace Addons\Oss\Providers;


use Addons\Oss\Expand\OssAdapter;
use League\Flysystem\Filesystem;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var string $addonName
     */
    protected $addonName = 'Oss';

    /**
     * @var string $moduleNameLower
     */
    protected $addonNameLower = 'oss';

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
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteProvider::class);
    }

    protected function registerService()
    {
        app('filesystem')->extend('oss', function ($app, $config) {

            $adapter = new OssAdapter(
                $config['oss_access_key_id'],
                $config['oss_access_key_secret'],
                $config['oss_bucket'],
                $config['oss_endpoint'],
            );

            return new Filesystem($adapter);
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        if (file_exists(addon_path($this->addonName, '/Config/config.php'))) {
            $this->mergeConfigFrom(
                addon_path($this->addonName, '/Config/config.php'), "filesystems.disks.{$this->addonNameLower}"
            );
        }

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
