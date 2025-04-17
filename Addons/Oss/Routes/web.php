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
        'prefix' => $prefix . '/addon/oss',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Oss\Controllers'
    ], function () {

    Route::get('config', 'OssController@config')->name('admin.addon.oss.config');
    Route::post('config', 'OssController@store');

});
