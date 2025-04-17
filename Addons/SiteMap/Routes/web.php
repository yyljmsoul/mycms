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
        'prefix' => $prefix . '/addon/sitemap',
        'namespace' => 'Addons\SiteMap\Controllers'
    ], function () {

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/', 'SiteMapController@index')->name('admin.addon.site_map.index');
        Route::post('/', 'SiteMapController@make');
    });

    Route::get('make', 'SiteMapController@make')->name('admin.addon.site_map.make');
    Route::get('update', 'SiteMapController@update');
    Route::get('make/{ident}', 'SiteMapController@makeMap')->name('admin.addon.site_map.makeIdent');
});
