<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'statistics'],function (){

    //订单消费统计(拼团/秒杀)
    Route::get('statiOrderByActivity','Home\StatisticsController@statiOrderByActivity');

    //分销消费统计
    Route::get('statiOrderBySale','Home\StatisticsController@statiOrderBySale');

    //数据折线统计图
    Route::get('getOrderTrend','Home\StatisticsController@getOrderTrend');

    //营收明细
    Route::get('getOrderList','Home\StatisticsController@getOrderList');
});

//秒杀列表
Route::get('/diy/getSkilList','Home\DiyOrderController@getSkilList');

//核销记录列表
Route::get('/diy/getSaleList','Home\DiyOrderController@getSaleList');
