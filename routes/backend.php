<?php

Route::namespace('Backend')->prefix('admin')->group(function (){
	
	Route::get('login', 'AuthController@index');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
	
	Route::middleware('admin')->group(function (){
		
		Route::get('dashboard', 'DashboardController@index');
		
		Route::get('product', 'ProductController@index');
		Route::get('product/data', 'ProductController@getData');

		



		Route::get('category', 'CategoryController@index');
		Route::get('category/data', 'CategoryController@getData');



		Route::get('user', 'UserController@index');
		Route::get('user/data', 'UserController@getData');
	});
});