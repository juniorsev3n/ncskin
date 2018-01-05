<?php

Route::group(['namespace' => 'Backend', 'prefix' => 'admin'], function (){
	
	Route::get('login', 'AuthController@index');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
	
	Route::middleware('admin')->group(function (){
		
		Route::get('dashboard', 'DashboardController@index');
		
		Route::get('product', 'ProductController@index');
		Route::get('product/data', 'ProductController@getData');
		Route::get('product/add', 'ProductController@getAdd');
		Route::post('product/add', 'ProductController@postAdd');
		Route::post('product/addImage', 'ProductController@addImage');
		Route::get('product/remove/{id}', 'ProductController@getRemove');
		Route::get('product/show/{id}', 'ProductController@show');

		

		Route::get('category', 'CategoryController@index');
		Route::get('category/data', 'CategoryController@getData');
		Route::get('category/ajax_list', 'CategoryController@getAjaxList');



		Route::get('user', 'UserController@index');
		Route::get('user/data', 'UserController@getData');


		Route::get('menu', 'MenuController@index');
		Route::get('menu/data', 'MenuController@getData');
	});
});