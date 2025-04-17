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
        'prefix' => $prefix . '/addon/alisms',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\AliSms\Controllers'
    ], function () {
    Route::get('/', 'AliSmsController@index')->name('admin.addon.ali_sms.index');
    Route::get('/edit', 'AliSmsController@edit')->name('admin.addon.ali_sms.edit');
    Route::post('/edit', 'AliSmsController@update');
    Route::get('/create', 'AliSmsController@create')->name('admin.addon.ali_sms.create');
    Route::post('/create', 'AliSmsController@store');
    Route::post('/destroy', 'AliSmsController@destroy');

    Route::get('/logs', 'AliSmsController@logs')->name('admin.addon.ali_sms.logs');
});
