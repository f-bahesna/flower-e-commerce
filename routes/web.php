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

Route::get('/','HomeController@index')->name('home-page');

Auth::routes();

Route::prefix('about')->group(function () {
        Route::get('/', 'About\AboutController@index')->name('about');
});

Route::prefix('user')->group(function () {
        Route::get('/user-logout', 'Auth\RegisterController@userLogout')->name('user.logout');
        Route::post('/user-register', 'Auth\RegisterController@userRegister')->name('user.register');
});

Route::prefix('product')->group(function () {
    Route::get('/', 'Product\ProductController@getAllProduct')->name('product.all');
    Route::get('/product-detail/{id}', 'Product\ProductController@getProductDetail')->name('product.detail');
    Route::post('/product-search', 'Product\ProductController@searchProduct')->name('product.search');
});

Route::prefix('cart')->group(function () {
    Route::post('/add-cart','Product\CartController@addProduct')->name('product.add.cart');
    Route::post('/show','Product\CartController@showProduct')->name('show.cart');
    Route::post('/delete-cart','Product\CartController@deleteCart')->name('delete.cart');
    Route::post('/show-detail','Product\CartController@showProductDetail')->name('show.cart.details');
    Route::post('/calculateTotal','Product\CartController@calculateTotal')->name('calculate.cart');
    Route::post('/cart-payment-section','Product\CartController@cartPayment')->name('cart.payment');
});

Route::prefix('jenis')->group(function () {
    Route::get('/','Jenis\JenisController@index')->name('jenis');
});
