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
        'prefix' => $prefix . '/addon/qiniu',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Qiniu\Controllers'
    ], function () {

    Route::get('config', 'QiNiuController@config')->name('admin.addon.oss.config');
    Route::post('config', 'QiNiuController@store');

});
