<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('entry', 'ApiController@entry');
Route::any('{ident}/entry', 'ApiController@entry');

Route::prefix('v1')->name('api.v1.')
    ->group(function () {

        Route::middleware('api.sign')->group(function () {

            Route::post('/categories', 'CmsController@categories');
            Route::post('/category/info', 'CmsController@categoryInfo');

            Route::post('/articles', 'CmsController@articles');
            Route::post('/article/info', 'CmsController@articleInfo');

            Route::post('/store/index', 'StoreController@index');
            Route::post('/store/search/keywords', 'StoreController@hotKeywords');
            Route::post('/store/categories', 'StoreController@categories');
            Route::post('/store/category/info', 'StoreController@categoryInfo');

            Route::post('/store/goods/list', 'StoreController@goodsList');
            Route::post('/store/goods/info', 'StoreController@goodsInfo');
            Route::post('/store/goods/comments', 'StoreController@goodsComments');
            Route::post('/store/cart', 'StoreController@cart');
            Route::post('/store/cart/total', 'StoreController@cartTotal');
            Route::post('/store/cart/delete', 'StoreController@deleteCartGoods');
            Route::post('/store/cart/store', 'StoreController@cartStore');
            Route::post('/store/order/confirm', 'OrderController@cartSettle');
            Route::post('/store/order/directBuy', 'OrderController@directSettle');
            Route::post('/store/order/submit', 'OrderController@submit');
            Route::post('/store/pay/order/{orderSn}', 'PayController@order');
            Route::post('/store/pay/submit', 'PayController@submit');

            Route::post('/comments', 'CmsController@comments');
            Route::post('/comment/submit', 'CmsController@submitComment');

            Route::post('/user/login', 'UserController@login');
            Route::post('/user/reg', 'UserController@reg');
            Route::post('/user/info', 'UserController@info');
            Route::post('/user/ranks', 'UserController@ranks');
            Route::post('/user/address', 'UserController@addresses');
            Route::post('/user/address/detail', 'UserController@address');
            Route::post('/user/address/default', 'UserController@defaultAddress');
            Route::post('/user/address/store', 'UserController@addressStore');
            Route::post('/user/address/update', 'UserController@addressUpdate');
            Route::post('/user/address/delete', 'UserController@addressDelete');
            Route::post('/user/orders', 'OrderController@orders');
            Route::post('/order/detail/{orderSn}', 'OrderController@orderDetail');
            Route::post('/order/finish/{orderSn}', 'OrderController@finish');
            Route::post('/order/cancel/{orderSn}', 'OrderController@cancel');

            Route::post('/system/attrs', 'SystemController@attrs');

            Route::post('/mini/login', 'MiniAppController@login');
            Route::post('/mini/info', 'MiniAppController@info');


        });

        Route::post('/timestamp', 'SystemController@timestamp');
        Route::post('/region', 'SystemController@region');

    });


Route::post('/store/pay/notify/{type}', 'PayController@notify')->name('store.pay.notify');


