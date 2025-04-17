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
    'namespace' => '\Modules\Mp\Http\Controllers\Admin'
], function () {
    Route::group(['prefix' => 'mp'], function () {

        Route::get('/mp_account', 'MpAccountController@index')->name('mp.mp_account');
        Route::get('/mp_account/create', 'MpAccountController@create')->name('mp.mp_account.create');
        Route::post('/mp_account/create', 'MpAccountController@store');
        Route::get('/mp_account/edit', 'MpAccountController@edit')->name('mp.mp_account.edit');
        Route::post('/mp_account/edit', 'MpAccountController@update');
        Route::post('/mp_account/destroy', 'MpAccountController@destroy');


        Route::get('/mp_article', 'MpArticleController@index')->name('mp.mp_article');
        Route::get('/mp_article/create', 'MpArticleController@create')->name('mp.mp_article.create');
        Route::post('/mp_article/create', 'MpArticleController@store');
        Route::get('/mp_article/edit', 'MpArticleController@edit')->name('mp.mp_article.edit');
        Route::post('/mp_article/edit', 'MpArticleController@update');
        Route::post('/mp_article/destroy', 'MpArticleController@destroy');
        Route::get('/mp_article/preview', 'MpArticleController@preview')->name('mp.mp_article.preview');


        Route::get('/mp_template', 'MpTemplateController@index')->name('mp.mp_template');
        Route::get('/mp_template/create', 'MpTemplateController@create')->name('mp.mp_template.create');
        Route::post('/mp_template/create', 'MpTemplateController@store');
        Route::get('/mp_template/edit', 'MpTemplateController@edit')->name('mp.mp_template.edit');
        Route::post('/mp_template/edit', 'MpTemplateController@update');
        Route::post('/mp_template/destroy', 'MpTemplateController@destroy');
        Route::get('/mp_template/preview', 'MpTemplateController@preview')->name('mp.mp_template.preview');
        Route::post('/mp_template/make', 'MpTemplateController@make')->name('mp.mp_template.make');

        Route::get('/mp_push_log', 'MpPushLogController@index')->name('mp.mp_push_log');
        Route::get('/mp_push_log/create', 'MpPushLogController@create')->name('mp.mp_push_log.create');
        Route::post('/mp_push_log/create', 'MpPushLogController@store');
        Route::get('/mp_push_log/edit', 'MpPushLogController@edit')->name('mp.mp_push_log.edit');
        Route::post('/mp_push_log/edit', 'MpPushLogController@update');
        Route::post('/mp_push_log/destroy', 'MpPushLogController@destroy');
        Route::get('/mp_push_log/preview', 'MpPushLogController@preview')->name('mp.mp_push_log.preview');
        Route::post('/mp_push_log/preview', 'MpPushLogController@sendPreview');
        Route::get('/mp_push_log/push', 'MpPushLogController@pushShow')->name('mp.mp_push_log.push');
        Route::post('/mp_push_log/push', 'MpPushLogController@push');


        Route::get('/mp_reply/edit', 'MpReplyController@edit')->name('mp.mp_reply.edit');
        Route::post('/mp_reply/edit', 'MpReplyController@update');
        Route::post('/mp_reply/destroy', 'MpReplyController@destroy');
        Route::get('/mp_reply/{id}', 'MpReplyController@index')->name('mp.mp_reply');
        Route::get('/mp_reply/{id}/create', 'MpReplyController@create')->name('mp.mp_reply.create');
        Route::post('/mp_reply/{id}/create', 'MpReplyController@store');

        Route::get('/mp_menu/{id}/edit', 'MpMenuController@edit')->name('mp.mp_menu.edit');
        Route::post('/mp_menu/{id}/edit', 'MpMenuController@update')->name('mp.mp_menu.update');
        Route::post('/mp_menu/destroy', 'MpMenuController@destroy');
        Route::post('/mp_menu/release', 'MpMenuController@release');
        Route::get('/mp_menu/{id}', 'MpMenuController@index')->name('mp.mp_menu');
        Route::get('/mp_menu/{id}/create', 'MpMenuController@create')->name('mp.mp_menu.create');
        Route::post('/mp_menu/{id}/create', 'MpMenuController@store')->name('mp.mp_menu.store');
        Route::post('/mp_menu/{id}/sort', 'MpMenuController@sort')->name('mp.mp_menu.sort');


        Route::get('/mp_material/edit', 'MpMaterialController@edit')->name('mp.mp_material.edit');
        Route::post('/mp_material/edit', 'MpMaterialController@update');
        Route::post('/mp_material/destroy', 'MpMaterialController@destroy');
        Route::get('/mp_material/{id}', 'MpMaterialController@index')->name('mp.mp_material');
        Route::get('/mp_material/{id}/create', 'MpMaterialController@create')->name('mp.mp_material.create');
        Route::post('/mp_material/{id}/create', 'MpMaterialController@store');


        Route::get('/mp_tags/{id}/edit', 'MpTagsController@edit')->name('mp.mp_tags.edit');
        Route::post('/mp_tags/{id}/edit', 'MpTagsController@update');
        Route::post('/mp_tags/{id}/destroy', 'MpTagsController@destroy');
        Route::get('/mp_tags/{id}', 'MpTagsController@index')->name('mp.mp_tags');
        Route::get('/mp_tags/{id}/create', 'MpTagsController@create')->name('mp.mp_tags.create');
        Route::post('/mp_tags/{id}/create', 'MpTagsController@store');



        Route::get('/mp_code/{id}/create', 'MpCodeController@create')->name('mp.mp_code.create');
        Route::post('/mp_code/{id}/create', 'MpCodeController@store');
        Route::get('/mp_code/{id}/edit', 'MpCodeController@edit')->name('mp.mp_code.edit');
        Route::post('/mp_code/{id}/edit', 'MpCodeController@update');
        Route::post('/mp_code/{id}/destroy', 'MpCodeController@destroy');
        Route::get('/mp_code/{id}', 'MpCodeController@index')->name('mp.mp_code');

        Route::get('/mp_user/{id}', 'MpUserController@index')->name('mp.mp_user');


        /* -curd- */
    });
});


Route::group([
    'namespace' => '\Modules\Mp\Http\Controllers\Web'
], function () {

    Route::any('/wechat/server/{ident}', 'WechatServerController@req')->name('wechat.server.req');
    Route::post('/wechat/menu/{ident}', 'WechatServerController@menu')->name('wechat.server.menu');

});
