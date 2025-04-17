<?php

$prefix = system_config('admin_prefix') ?: 'admin';

Route::group(
    [
        'prefix' => $prefix . '/addon/directmail',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\DirectMail\Controllers'
    ], function () {

    Route::get('/', 'DirectMailController@index')->name('admin.addon.direct_mail.index');
    Route::get('/edit', 'DirectMailController@edit')->name('admin.addon.direct_mail.edit');
    Route::post('/edit', 'DirectMailController@update');
    Route::get('/create', 'DirectMailController@create')->name('admin.addon.direct_mail.create');
    Route::post('/create', 'DirectMailController@store');
    Route::post('/destroy', 'DirectMailController@destroy');

});
