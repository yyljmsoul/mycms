<?php


namespace Addons\Ads\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteProvider extends RouteServiceProvider
{

    /**
     * The addon namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Addons\Ads\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
        $this->mapForbidRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(addon_path('Ads', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(addon_path('Ads', '/Routes/api.php'));
    }


    /**
     * 防屏蔽路由
     * @return void
     */
    protected function mapForbidRoutes()
    {
        Route::middleware('web')
            ->group(addon_path('Ads', '/Routes/forbid.php'));
    }
}
