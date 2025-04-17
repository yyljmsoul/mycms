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
    'namespace' => '\Modules\Shop\Http\Controllers\Admin'
], function () {
    Route::group(['prefix' => 'shop'], function () {

        Route::get('/config', 'ShopConfigController@index')->name('shop.config');
        Route::post('/config', 'ShopConfigController@store');

        Route::get('/category', 'CategoryController@index')->name('shop.category');
        Route::get('/category/edit', 'CategoryController@edit')->name('shop.category.edit');
        Route::post('/category/edit', 'CategoryController@update');
        Route::get('/category/create', 'CategoryController@create')->name('shop.category.create');
        Route::post('/category/create', 'CategoryController@store');
        Route::post('/category/destroy', 'CategoryController@destroy');
        Route::get('/category/metaToGoods', 'CategoryController@metaToGoods')->name('shop.category.metaToGoods');


        Route::get('/goods', 'GoodsController@index')->name('shop.goods');
        Route::get('/goods/edit', 'GoodsController@edit')->name('shop.goods.edit');
        Route::post('/goods/edit', 'GoodsController@update');
        Route::get('/goods/create', 'GoodsController@create')->name('shop.goods.create');
        Route::post('/goods/create', 'GoodsController@store');
        Route::post('/goods/destroy', 'GoodsController@destroy');
        Route::get('/goods/lang', 'GoodsLangController@index')->name('shop.goods.lang');
        Route::get('/goods/lang/edit', 'GoodsLangController@edit')->name('shop.goods.langEdit');
        Route::post('/goods/lang/edit', 'GoodsLangController@update');
        Route::get('/goods/lang/create', 'GoodsLangController@create')->name('shop.goods.langCreate');
        Route::post('/goods/lang/create', 'GoodsLangController@store');
        Route::post('/goods/lang/destroy', 'GoodsLangController@destroy');

        Route::get('/pay/logs', 'PayController@logs')->name('pay.logs');
        Route::get('/pay/config', 'PayController@config')->name('pay.config');
        Route::post('/pay/config', 'PayController@store');


        /* -curd- */

    });
});

Route::group([
    'namespace' => '\Modules\Shop\Http\Controllers\Web'
], function () {
    Route::get('/goods/{id}', 'ShopController@goods')->name('store.goods');
    Route::get('/store', 'ShopController@store')->name('store.index');
    Route::get('/store/page/{page}', 'ShopController@store')->where(['page' => '[0-9]+']);
    Route::get('/store/{cid}', 'ShopController@category')->name('store.category')->where(['cid' => '[0-9]+']);
    Route::get('/store/{cid}/page/{page}', 'ShopController@category')->where(['cid' => '[0-9]+', 'page' => '[0-9]+']);

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/store/create/order', 'ShopController@createOrder')->name('store.create.order');
    });
});
