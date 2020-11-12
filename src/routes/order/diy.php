<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'diy/'],function (){

    //数据简报
    Route::get('brieOrder','Home\DiyOrderController@brieOrder');

    //折线统计图数据
    Route::get('getOrderTrend','Home\DiyOrderController@getOrderTrend');

    //数据表格
    Route::get('getTotalList','Home\DiyOrderController@getTotalList');

    //获取订单资源
    Route::get('getOrderResou','Home\DiyOrderController@getOrderResou');

    //导出数据统计
    Route::get('exportOrder','Home\DiyOrderController@exportOrder');
});

