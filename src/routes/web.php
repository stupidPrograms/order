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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::group(['prefix' => 'api'], function () {
//    Route::group(['prefix' => 'order'], function () {
//        Route::get('/test', 'OrderController@testOrder');
//        Route::get('/cancel', 'OrderController@cancelOrder');
//        Route::get('/operational', 'OrderController@operationalRecord');
//        Route::get('/shop/statistics', 'OrderController@shopStatistics');
//        Route::group(['prefix' => 'address'], function (){
//            Route::get('/default', 'AddressController@defaultAddress');
//            Route::put('/default/setting/{id}', 'AddressController@setDefaultAddress');
//        });
//        Route::resource('/address', 'AddressController');//['update','edit','show','destroy']
//
//        Route::group(['prefix' => 'admin', 'middleware' => 'admin'],  function () {
//            Route::get('/index', 'AdminController@index');
//        });
//        Route::get('/user', 'OrderController@userOrder');
//        Route::get('/user/status', 'OrderController@orderStatusNum');
//        Route::get('/user/receipt', 'OrderController@receiptGoods');
//    });
//    Route::resource('order', 'OrderController', ['only' => ['index','store','show','update', 'destroy']]);
//
//});
