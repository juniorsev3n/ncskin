<?php

Route::namespace('Frontend')->group(function (){
	
	Route::get('login', 'LoginController@index');
	Route::post('login', 'LoginController@postLogin');
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
