<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$prefix = system_config('admin_prefix') ?: 'admin';

Route::group(
    [
        'prefix' => $prefix . '/addon/seo',
        'namespace' => 'Addons\Seo\Controllers'
    ], function () {

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/config', 'SeoController@config')->name('admin.addon.seo.config');
        Route::post('/config', 'SeoController@store');
    });

});
