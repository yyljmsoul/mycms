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
        'prefix' => $prefix . '/addon/link_submit',
        'namespace' => 'Addons\LinkSubmit\Controllers'
    ], function () {

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/', 'LinkSubmitController@index')->name('admin.addon.link_submit.index');
        Route::get('config', 'LinkSubmitController@config')->name('admin.addon.link_submit.config');
        Route::post('config', 'LinkSubmitController@store');
        Route::get('create', 'LinkSubmitController@create')->name('admin.addon.link_submit.create');
        Route::post('create', 'LinkSubmitController@push');
    });

    Route::get('crontab', 'LinkSubmitController@crontab')->name('admin.addon.link_submit.crontab');

});
