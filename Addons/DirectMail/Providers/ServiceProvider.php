<?php


namespace Addons\DirectMail\Providers;


use Illuminate\Mail\MailManager;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var string $addonName
     */
    protected $addonName = 'DirectMail';

    /**
     * @var string $moduleNameLower
     */
    protected $addonNameLower = 'direct_mail';

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

    /**
     * 注册服务
     * @return void
     */
    protected function registerService()
    {
        $this->app->resolving('mail.manager', function (MailManager $transportManager) {
            $transportManager->extend('directmail', function () {
                $region = config('direct_mail.region');
                $appKey = config('direct_mail.access_key');
                $appSecret = config('direct_mail.access_secret');
                $accountName = config('direct_mail.account_name');
                $accountAlias = config('direct_mail.alias');

                return new DirectMailTransport($region, $appKey, $appSecret, $accountName, $accountAlias);
            });
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            addon_path($this->addonName, '/Config/config.php'), $this->addonNameLower
        );

        $this->mergeConfigFrom(
            addon_path($this->addonName, '/Config/config.php'), "mail.mailers.directmail"
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
