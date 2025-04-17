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
        'prefix' => $prefix . '/addon/bing_submit_url',
        'namespace' => 'Addons\BingSubmitUrl\Controllers'
    ], function () {

    Route::group(['middleware' => 'admin.auth'], function () {

        Route::get('/', 'SubmitController@index')->name('admin.addon.bing_submit_url.index');
        Route::get('/config', 'SubmitController@config')->name('admin.addon.bing_submit_url.config');
        Route::post('/config', 'SubmitController@store');
        Route::get('/create', 'SubmitController@create')->name('admin.addon.bing_submit_url.create');
        Route::post('/create', 'SubmitController@push');
    });

    Route::get('crontab', 'SubmitController@crontab')->name('admin.addon.bing_submit_url.crontab');
});
