<?php

use App\Http\Middleware\SetShopIdByOrderIdMiddleWare;
use App\Http\Middleware\ShopIdAuthMiddleWare;
use Illuminate\Support\Facades\Route;

//商家后台
Route::group(['prefix' => 'home'],  function () {
    //检测uuid和是否可以操作shop_id下面的order
    Route::group([
        'middleware'=> [
            SetShopIdByOrderIdMiddleWare::class, //先检测有没有order_id，有的话就自动设置订单对应的shop_id
            ShopIdAuthMiddleWare::class, //再检测shop_id是不是属于本用户的
            //不能用policy来控制，因为这个版本的collection有点问题
            //'middleware'=>"can:manage,shop_orders"//.\App\Policies\ShopOrderPolicy::class,//用policy来控制
        ]
    ],function (){
        Route::get('/orders/{id}', 'Home\ShopOrderController@show');            //订单路由
        Route::post('/orders/{id}', 'Home\ShopOrderController@update');         //店铺后台修改订单
        Route::get('/shop/{shop_id}/orders', 'Home\ShopOrderController@index'); //店铺订单路由
        Route::post('/sale','Home\ShopOrderController@updateSale');             //输入核销码完成产品核销

        Route::get('/orders/{id}/operation_records', 'Home\StatisticsController@operationalRecord');//订单操作记录
        Route::get('/shop/{shop_id}/statistics', 'Home\StatisticsController@shopStatistics');//单/多店铺首页订单统计数据




    });
});
