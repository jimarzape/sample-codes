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

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	Route::get('/', 'Admin\DashboardController@index')->name('dashboard');

	/* ITEM STARt */
	Route::get('/item', 'Admin\ItemController@index')->name('items');
	Route::post('/item/new', 'Admin\ItemController@_new')->name('items_new');
	Route::post('/item/save', 'Admin\ItemController@save')->name('items_save');
	Route::post('/item/toggle', 'Admin\ItemController@active_toggle')->name('item_active_toggle');
	Route::post('/item/archived', 'Admin\ItemController@archived')->name('items_archived');
	Route::post('/item/view', 'Admin\ItemController@view')->name('items_view');
	Route::post('/item/update', 'Admin\ItemController@update')->name('items_update');
 	/* ITEM END */


	/* CATEGORY START */
	Route::get('/category', 'Admin\CategoryController@index')->name('category');
	Route::post('/category/new', 'Admin\CategoryController@_new')->name('category_new');
	Route::post('/category/save', 'Admin\CategoryController@_save')->name('category_save');
	Route::post('/category/view', 'Admin\CategoryController@view')->name('category_view');
	Route::post('/category/update', 'Admin\CategoryController@update')->name('category_update');
	Route::post('/category/archived', 'Admin\CategoryController@archived')->name('category_archived');
	/* CATEGORY END */

	/* USER START */
	Route::get('/user', 'Admin\UserController@index')->name('user');
	Route::post('/user/new', 'Admin\UserController@_new')->name('user_new');
	Route::post('/user/save', 'Admin\UserController@_save')->name('user_save');
	Route::post('/user/view', 'Admin\UserController@view')->name('user_view');
	Route::post('/user/update', 'Admin\UserController@update')->name('user_update');
	Route::post('/user/inactive', 'Admin\UserController@inactive')->name('user_inactive');
	Route::post('/user/pin', 'Admin\UserController@generate_pin')->name('user_pin');
	Route::post('/user/auth', 'Admin\UserController@password_authenticate')->name('user_password_authenticate');
	/* USER END */


	/* USER PERMISSION STARt */
	Route::get('/permission', 'Admin\PermissionController@index')->name('permission');
	Route::any('/permission/new','Admin\PermissionController@_new')->name('permission_new');
	Route::post('/permission/save','Admin\PermissionController@_save')->name('permission_save');
	Route::any('/permission/view','Admin\PermissionController@view')->name('permission_view');
	Route::any('/permission/update','Admin\PermissionController@update')->name('permission_update');
	Route::any('/permission/archived','Admin\PermissionController@archived')->name('permission_archived');
	/* USER PERMISSION END */

	/* MISC START */
	Route::any('/upload/picture','Admin\UploadController@upload_picture')->name('upload_picture');
	Route::get('/logs', 'Admin\LogsController@index')->name('logs');
	/* MISC END */

});


