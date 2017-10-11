<?php

Route::namespace('Frontend')->group(function (){
	
	Route::get('login', 'AuthController@index');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
	Route::get('password-reset', 'AuthController@getResetPassword');
	Route::get('contact', function()
		{
			return view('frontend.contact');
		});
	Route::get('about', function()
		{
			return view('frontend.about');
		});
	Route::get('shop', 'ShopController@index')->name('shop');
});

Route::namespace('Frontend')->prefix('product')->group(function(){
	Route::get('/', 'ProductController@index');
	Route::get('{slug}', 'ProductController@show');
});
