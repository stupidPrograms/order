<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'order'], function () {

    include __DIR__ . "/order/admin.php";
    //公共资源
    include  __DIR__.'/order/public.php';
    //落地页
    include __DIR__ . "/order/diy.php";

    Route::group(['middleware'=>"auth:member"],function (){
        //前台用户
        include __DIR__ . "/order/user.php";

        include __DIR__ . "/order/address.php";
        //商家后台
        include __DIR__ . "/order/home.php";

        //统计
        include __DIR__ . "/order/statistics.php";

    });
    Route::group(['middleware'=>\App\Http\Middleware\AdminAccessMiddleware::class],function () {
        //总后台

    });
});
