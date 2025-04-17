<?php

$prefix = system_config('admin_prefix') ?: 'admin';

Route::group(
    [
        'prefix' => $prefix . '/addon/system_log',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\SystemLog\Controllers'
    ], function () {
    Route::get('/', 'SystemLogController@index')->name('admin.addon.system_log.index');
    Route::get('show', 'SystemLogController@show')->name('admin.addon.system_log.show');
});
