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
        'prefix' => $prefix . '/addon/upgrade',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Upgrade\Controllers'
    ], function () {

    Route::get('/', 'UpgradeController@index')->name('admin.addon.upgrade.index');
    Route::get('/version', 'UpgradeController@version')->name('admin.addon.upgrade.version');
    Route::post('/version', 'UpgradeController@update');

});
