<?php

use Illuminate\Support\Facades\Route;

//用户订单
Route::get('/shop/getCountMoney', 'OrderController@getCountMoney');                                  //获取商家的已支付未收货的金额
Route::group(['prefix' => '/user'], function () {
    Route::get('/testOrder','OrderController@testOrder');
    Route::get('/status', 'OrderController@orderStatusNum');                                         //用户订单状态统计
    //Route::get('/orderNum', 'OrderController@orderNum');                                           //用户订单状态统计
    Route::put('/cancel/{id}', 'OrderController@cancelOrder');                                       //取消订单
    Route::get('/shop/{id}', 'OrderController@shopOrder');                                           //用户店铺订单
    Route::put('/confirmReception/{id}', 'OrderController@confirmReception');                        //确认收货
    Route::post('/order_notify', 'OrderController@order_notify');                                    //支付金额为0的情况下，使用此回调
    Route::resource('/orders', 'OrderController', ['only' => ['index','store','show', 'destroy']]);  //订单控制器资源路由


    Route::post('/seckOrder','OrderController@seckOrder');              //创建秒杀订单
    Route::post('/groupOrder','OrderController@groupOrder');            //创建拼团订单
    Route::post('/create_sale','OrderController@create_sale');          //创建虚拟核销订单
    Route::post('/endSaleOrder','OrderController@endSaleOrder');        //结束虚拟核销订单

    Route::get('/creatSon','OrderController@creatSon');                 //创建虚拟订单的子订单号
    Route::put('/upSaleCoupon','OrderController@upSaleCoupon');         //核销订单修改优惠券
    Route::put('/upOrderPirce','OrderController@upOrderPirce');         //核销订单修改





    Route::get('/doas','OrderController@doas');
    Route::get('/inteRate','OrderController@inteRate');
    Route::get('/saleCallback','OrderController@saleCallback');
    Route::get('/doGroupOrder','OrderController@doGroupOrder');
    Route::get('/dosetOrder','OrderController@dosetOrder');



});
