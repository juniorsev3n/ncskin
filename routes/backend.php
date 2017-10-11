<?php

Route::namespace('Backend')->prefix('admin')->group(function (){
	
	Route::get('login', 'AuthController@index');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
	Route::get('dashboard', 'DashboardController@index');
});