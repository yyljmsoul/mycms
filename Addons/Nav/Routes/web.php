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
        'prefix' => $prefix . '/addon/nav',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Nav\Controllers'
    ], function () {

    Route::get('/', 'NavController@show')->name('admin.addon.nav.index');
    Route::get('/edit', 'NavController@edit')->name('admin.addon.nav.edit');
    Route::post('/edit', 'NavController@update');
    Route::get('/create', 'NavController@create')->name('admin.addon.nav.create');
    Route::post('/create', 'NavController@store');
    Route::post('/destroy', 'NavController@destroy');

    Route::get('/config', 'NavController@config')->name('admin.addon.nav.config');
    Route::post('/config', 'NavController@cfgStore');

});
