<?php

use Illuminate\Support\Facades\Route;

//用户地址
Route::group(['prefix' => '/address'], function () {
    Route::get('/default', 'AddressController@defaultAddress');//默认地址
    Route::put('/default/setting/{id}', 'AddressController@setDefaultAddress');//设置默认地址
    Route::resource('/items', 'AddressController');//['update','edit','show','destroy']//地址资源路由
});
