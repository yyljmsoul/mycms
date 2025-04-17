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
    'namespace' => '\Modules\Api\Http\Controllers\Admin'
], function () {

    Route::group(['prefix' => 'api'],function (){

        Route::get('/', 'ApiController@index')->name('api.api');
        Route::get('/create', 'ApiController@create')->name('api.api.create');
        Route::post('/create', 'ApiController@store');
        Route::get('/edit', 'ApiController@edit')->name('api.api.edit');
        Route::post('/edit', 'ApiController@update');
        Route::post('/destroy', 'ApiController@destroy');
        Route::get('/table/fields', 'ApiController@tableFields')->name('api.api.fields');


		Route::get('/data_source', 'DataSourceController@index')->name('api.data_source');
        Route::get('/data_source/create', 'DataSourceController@create')->name('api.data_source.create');
        Route::post('/data_source/create', 'DataSourceController@store');
        Route::get('/data_source/edit', 'DataSourceController@edit')->name('api.data_source.edit');
        Route::post('/data_source/edit', 'DataSourceController@update');
        Route::post('/data_source/destroy', 'DataSourceController@destroy');

        Route::get('/data_manage', 'DataManageController@index')->name('api.data_manage.index');
        Route::get('/data_manage/create', 'DataManageController@create')->name('api.data_manage.create');
        Route::post('/data_manage/create', 'DataManageController@store');
        Route::get('/data_manage/edit', 'DataManageController@edit')->name('api.data_manage.edit');
        Route::post('/data_manage/edit', 'DataManageController@update');
        Route::post('/data_manage/destroy', 'DataManageController@destroy');

		Route::get('/api_project', 'ApiProjectController@index')->name('api.api_project');
        Route::get('/api_project/create', 'ApiProjectController@create')->name('api.api_project.create');
        Route::post('/api_project/create', 'ApiProjectController@store');
        Route::get('/api_project/edit', 'ApiProjectController@edit')->name('api.api_project.edit');
        Route::post('/api_project/edit', 'ApiProjectController@update');
        Route::post('/api_project/destroy', 'ApiProjectController@destroy');


		/* -curd- */
    });
});
