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

Route::group([
    'prefix' => $prefix,
    'middleware' => 'admin.auth',
    'namespace' => '\Modules\Order\Http\Controllers\Admin'
], function () {

    Route::group(['prefix' => 'order'], function () {

        Route::get('/', 'OrderController@index')->name('order.admin');
        Route::get('/detail', 'OrderController@detail')->name('order.admin.detail');
        Route::get('/express', 'OrderController@express')->name('order.admin.express');
        Route::post('/express', 'OrderController@delivery')->name('order.admin.delivery');

        /* -curd- */
    });

});
