<?php

namespace App\Http\Middleware;

use App\Api\Helpers\Api\ApiResponse;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\resultMsg;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\ShopInfo;
use App\Tars\cservant\BB\Shop\ShopTcp\ShopServant;
use App\Tars\impl\TarsHelper;
use Closure;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Translation\Exception\InvalidResourceException;


//判断店铺是否属于商家用户
class ShopIdAuthMiddleWare
{
    use ApiResponse;

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $shop_id = $request->shop_id;
        if (!$shop_id || !is_numeric($shop_id) || $shop_id<=0) {
            return $this->failed("shop_id未定义或有误：".$shop_id);
        }

        if ($uuid = $request->user()->uuid) {
            //只允许店铺所有者操作订单（后续用角色权限控制）
            /** @var ShopServant $shopServant */
            $shopServant = TarsHelper::servantFactory(ShopServant::class);
           // $res = new resultMsg();
            //$shopServant->isMyShop($uuid,$shop_id,$res);
            //if ($res->code == 200 && $res->data == 1) { //店铺是属于当前用户的
                $shop_info = new ShopInfo();
                $resultMsg = new resultMsg();
                $shopServant->ShopInfo($shop_id,$resultMsg,$shop_info);

                if ($resultMsg->msg == '店铺不存在')  return $this->failed('店铺不存在');

                $request->shop_info = $shop_info;
                $request->shopServant = $request->shop_servant = $shopServant;
                return $next($request);
            //}
        }
        return $this->unAuth("您未被授权操作本店铺订单接口");
    }
}
