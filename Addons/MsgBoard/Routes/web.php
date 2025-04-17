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
        'prefix' => $prefix . '/addon/msg_board',
        'namespace' => 'Addons\MsgBoard\Controllers'
    ], function () {

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/', 'MsgBoardAdminController@index')->name('admin.addon.msg_board.index');
        Route::get('/edit', 'MsgBoardAdminController@edit')->name('admin.addon.msg_board.edit');
        Route::post('/edit', 'MsgBoardAdminController@update');
        Route::post('/destroy', 'MsgBoardAdminController@destroy');
    });

    Route::post('submit', 'MsgBoardWebController@submit')->middleware('throttle:3,1')->name('admin.addon.msgBoard.submit');

});
