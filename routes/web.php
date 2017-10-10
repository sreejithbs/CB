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

Route::get('/', function(){
	return view('welcome');
});


Auth::routes();

Route::GET('/home', 'CoinController@index')->name('home');
Route::GET('/createAddress/{walletID}', 'CoinController@createAddress')->name('createAddress');
Route::GET('sendBTC', 'CoinController@sendBTC')->name('sendBTC');
Route::GET('BTCsendForm/{currentReceiveAddress}', 'CoinController@BTCsendForm')->name('BTCsendForm');
