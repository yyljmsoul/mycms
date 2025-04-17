<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '{lang}', 'where' => ['lang' => join("|", array_keys(system_lang()))]], function () {

    Route::get('/', function ($path) {
        set_current_lang($path);
        return App::call('Modules\Cms\Http\Controllers\Web\CmsController@index');
    });

    $replaceRoutes = str_replace(array_map(function ($item) {
        return $item . "/";
    }, array_keys(system_lang())), "", request()->path());

    Route::get($replaceRoutes, function ($path) use ($replaceRoutes) {

        set_current_lang($path);

        $kernel = \app()->make(Illuminate\Contracts\Http\Kernel::class);

        $response = tap($kernel->handle(
            request()->propertyAware('pathInfo', "/{$replaceRoutes}")
        ))->send();

        return $kernel->terminate(request(), $response);
    });
});
