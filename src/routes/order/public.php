<?php
use Illuminate\Support\Facades\Route;

Route::get('/user/orderNum', 'OrderController@orderNum');       //用户订单状态统计


Route::any('/user/orderNotify','OrderController@orderNotify');                  //虚拟订单回调
Route::get('/user/getOrderPayType','OrderController@getOrderPayType');          //查询订单支付状态
Route::put('/user/endSaleOrder','OrderController@endSaleOrder');                //结束核销订单
Route::get('/admin/getOrderCount','Home\ShopOrderController@getOrderCount');    //统计当前店铺的订单数量
Route::post('/admin/modifyGroupOrder','Home\ShopOrderController@modifyGroupOrder');    //修改拼团订单的拼团状态

Route::get('/admin/getOrderTask','Home\StatisticsController@getOrderTask');    //订单权重统计

