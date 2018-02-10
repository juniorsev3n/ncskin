<?php

Route::group(['namespace' => 'Frontend'], function(){

    Route::get('login', 'AuthController@index');
    Route::post('login', 'AuthController@postLogin');
    Route::get('login/{provider}', 'AuthController@redirectToProvider');
    Route::get('login/{provider}/callback', 'AuthController@handleProviderCallback');
    Route::get('logout', 'AuthController@getLogout');
    Route::get('password-reset', 'AuthController@getResetPassword');
    Route::post('password-reset', 'AuthController@postResetPassword');
    Route::get('reset-password/{id}/{reminder}', 'AuthController@verifyResetPassword')->name('reset-password');
    Route::get('activation/{id}/{reminder}', 'AuthController@activation')->name('activation');
    Route::get('aktivasi', 'AuthController@getAktifasi')->name('aktifasi');
    Route::post('aktivasi', 'AuthController@postAktifasi');
    Route::post('register', 'AuthController@postRegister');
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

});
