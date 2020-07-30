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

Route::get('/user-logout', 'Auth\RegisterController@userLogout')->name('user.logout');
Route::post('/user-register', 'Auth\RegisterController@userRegister')->name('user.register');

Route::get('/product-detail', 'Product\ProductController@getProductDetail')->name('product.detail');
Route::post('/product-search', 'Product\ProductController@searchProduct')->name('product.search');
