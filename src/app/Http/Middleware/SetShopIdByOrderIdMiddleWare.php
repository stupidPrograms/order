<?php

namespace App\Http\Middleware;

use App\Api\Helpers\Api\ApiResponse;
use App\Models\Order;
use Closure;
//判断订单是否属于商家用户
class SetShopIdByOrderIdMiddleWare
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $orderIdIndex = "id")
    {
//        return response()->json($request->all());
        //检测路由中捕获的订单id
        $order_id = $request->$orderIdIndex;
        if (is_numeric($order_id) && $order_id > 0) {
            $order = Order::withTrashed()->where('id',$order_id)->firstOrFail();
            $request->shop_id = $order->shop_id;
        }
        return $next($request);
    }
}
