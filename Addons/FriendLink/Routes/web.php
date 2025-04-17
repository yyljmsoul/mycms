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
        'prefix' => $prefix . '/addon/friend_link',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\FriendLink\Controllers'
    ], function () {
    Route::get('/', 'FriendLinkController@index')->name('admin.addon.friend_link.index');
    Route::get('/edit', 'FriendLinkController@edit')->name('admin.addon.friend_link.edit');
    Route::post('/edit', 'FriendLinkController@update');
    Route::get('/create', 'FriendLinkController@create')->name('admin.addon.friend_link.create');
    Route::post('/create', 'FriendLinkController@store');
    Route::post('/destroy', 'FriendLinkController@destroy');

    Route::get('/config', 'FriendLinkController@config')->name('admin.addon.friend_link.config');
    Route::post('/config', 'FriendLinkController@storeCfg');
});
