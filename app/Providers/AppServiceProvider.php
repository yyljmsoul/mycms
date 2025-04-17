<?php

namespace App\Providers;

use App\Macros\RequestMacro;
use Expand\We7\Providers\We7ServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    public function register()
    {
        $this->we7Service();

        Request::mixin($this->app->make(RequestMacro::class));

        request()->setLocale("");
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerConfig();
        $this->templateViews();
        $this->loadThemeFunctions();
        $this->openHttps();
        $this->loadThemeConfig();
        $this->loadThemeSystemConfig();
    }

    /**
     * 加载模板
     *
     * @return void
     */
    protected function templateViews()
    {
        $this->loadViewsFrom(base_path("Template"), 'template');
    }

    /**
     * 加载管道操作配置
     *
     * @return void
     */
    protected function registerConfig()
    {

        if (file_exists(base_path('bootstrap/cache/pipeline.php'))) {
            $this->mergeConfigFrom(
                base_path('bootstrap/cache/pipeline.php'), 'pipeline'
            );
        }

    }

    /**
     * 加载模板自定义函数
     *
     * @return void
     */
    protected function loadThemeFunctions()
    {
        $theme = system_config('cms_theme') ?? 'default';
        $functions = base_path('Template/' . $theme . '/helpers/functions.php');

        if (file_exists($functions)) {
            include_once $functions;
        }
    }


    /**
     * 开启 HTTPS
     * @return void
     */
    protected function openHttps()
    {
        if (env('IS_HTTPS')) {

            URL::forceScheme('https');
        }
    }

    /**
     * 开启微擎模式
     * @return void
     */
    protected function we7Service()
    {
        if (env('IS_WE7')) {

            $this->app->register(We7ServiceProvider::class);

            if ($uniacid = \request()->input('i')) {

                session(['uniacid' => $uniacid]);
            }
        }
    }

    /**
     * 加载模板自定义配置
     *
     * @return void
     */
    protected function loadThemeConfig()
    {
        $theme = system_config('cms_theme') ?? 'default';
        $path = base_path('Template/' . $theme . '/config/template_config.php');

        if (file_exists($path)) {

            $this->mergeConfigFrom($path, 'template.config');
        }
    }

    /**
     * 加载模板后台配置
     *
     * @return void
     */
    protected function loadThemeSystemConfig()
    {
        $theme = system_config('cms_theme') ?? 'default';
        $path = base_path('Template/' . $theme . '/config/system_config.php');

        if (file_exists($path)) {

            $this->mergeConfigFrom($path, 'template.system');
        }
    }

}
