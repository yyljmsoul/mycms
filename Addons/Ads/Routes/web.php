<?php

$prefix = system_config('admin_prefix') ?: 'admin';

Route::group(
    [
        'prefix' => $prefix . '/addon/ads',
        'middleware' => 'admin.auth',
        'namespace' => 'Addons\Ads\Controllers'
    ], function () {
    Route::get('/', 'AdsController@index')->name('admin.addon.ads.index');
    Route::get('/review', 'AdsController@review')->name('admin.addon.ads.review');
    Route::get('/edit', 'AdsController@edit')->name('admin.addon.ads.edit');
    Route::post('/edit', 'AdsController@update');
    Route::get('/create', 'AdsController@create')->name('admin.addon.ads.create');
    Route::post('/create', 'AdsController@store');
    Route::post('/destroy', 'AdsController@destroy');
    Route::get('/config', 'AdsController@config')->name('admin.addon.ads.config');
    Route::post('/config', 'AdsController@storeCfg');
});

Route::group(['namespace' => 'Addons\Ads\Controllers'], function () {
    Route::get('/ad/{code}/jump', 'AdResourceController@jump')->name('admin.addon.ads.jump');
});
