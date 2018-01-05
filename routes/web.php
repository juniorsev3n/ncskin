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

Route::get('/', function () {
	$products = \App\Models\Product::where('is_homepage', TRUE)
											 ->where('active', TRUE) 
											 ->orderBy('created_at', 'DESC')
											 ->take(8)
											 ->get();
    return view('frontend.home', compact('products'));
});

	



Route::get('/test', function (){
    \Mail::to('juniorsev3n@gmail.com')
            ->send(new \App\Mail\TestEmail);
});