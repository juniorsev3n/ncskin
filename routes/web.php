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
	Route::get('cart', 'ShopController@getCart')->name('cart');


	Route::get('/payment-confirmation', 'ClientController@paymentConfirm');
    Route::post('/payment-confirmation', 'ClientController@postPaymentConfirm');


    /**************************************
     * Route customer for payment process *
     **************************************/

        /***********************************
         * Route customer for showing cart *
         ***********************************/
        Route::get('cart', 'CartController@index');
        Route::get('destroy/{rowId}', 'CartController@destroy');
        Route::post('add-to-cart', 'CartController@cart');
        Route::post('update-cart', 'CartController@update');

        /***********************************
         * Route customer for payment term *
         ***********************************/
        Route::get('payment', 'PaymentController@create');
        Route::post('recap', 'PaymentController@getRecap');

        Route::post('save-pembayaran', 'PaymentController@store');
        Route::post('konfirmasi-pembayaran', 'PaymentController@confirm');
        Route::get('konfirmasi-pembayaran/atm-bersama', 'PaymentController@confirm');
        Route::post('upload-konfirmasi-pembayaran', 'PaymentController@beforeDone');
        Route::get('email-konfirmation/{kode}', 'PaymentController@beforeDone');
        Route::post('simpan-konfirmasi-pembayaran', 'PaymentController@storePayment');
        Route::post('simpan-transaction', 'PaymentController@saveTransaction');
        Route::get('selesai', 'PaymentController@done');

        // tambahan get invoice in pdf
        Route::get('getinvoice/{kode}', 'PaymentController@getInvoice');


Route::prefix('product')->group(function(){
	Route::get('/', 'ProductController@index');
	Route::get('{slug}', 'ProductController@show');
});



Route::get('/test', function (){
    \Mail::to('juniorsev3n@gmail.com')
            ->send(new \App\Mail\TestEmail);
});