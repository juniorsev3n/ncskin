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

		Route::get('page', 'PageController@index');
		Route::get('page/data', 'PageController@getData');
		Route::get('page/add', 'PageController@getAdd');
		Route::post('page/add', 'PageController@postAdd');
		Route::post('page/addImage', 'PageController@addImage');
		Route::get('page/remove/{id}', 'PageController@getRemove');
		Route::get('page/show/{id}', 'PageController@show');

		

		Route::get('category', 'CategoryController@index');
		Route::get('category/data', 'CategoryController@getData');
		Route::get('category/ajax_list', 'CategoryController@getAjaxList');



		Route::get('user', 'UserController@index');
		Route::get('user/data', 'UserController@getData');


		Route::get('menu', 'MenuController@index');
		Route::get('menu/add', 'MenuController@getAdd');
		Route::post('menu/add', 'MenuController@postAdd');
		Route::get('menu/data', 'MenuController@getData');
	});
});