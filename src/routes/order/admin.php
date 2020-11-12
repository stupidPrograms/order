<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/'],function (){
    //数据简报
    Route::get('brieOrder','Home\AdminOrderController@brieOrder');

    //待处理事务
    Route::get('getPendingOrder','Home\AdminOrderController@getPendingOrder');

    //概括首页折线统计图
    Route::get('getOrderTrend','Home\AdminOrderController@getOrderTrend');

    //漏斗數據
    Route::get('getOrderType','Home\AdminOrderController@getOrderType');
});
