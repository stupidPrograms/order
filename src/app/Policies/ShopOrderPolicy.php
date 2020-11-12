<?php

namespace App\Policies;

use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\resultMsg;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\ShopServant;
use App\Tars\impl\TarsHelper;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ShopOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(Request $request){
        return true;
        $shop_id = $request->shop_id;
        if (!$shop_id || !is_int($shop_id) || $shop_id<=0) {
            return false;
        }
        if ($uuid = $request->user()->uuid) {
            //只允许店铺所有者操作订单（后续用角色权限控制）
            /** @var ShopServant $shopServant */
            $shopServant = TarsHelper::servantFactory(ShopServant::class);
            $res = new resultMsg();
            $shopServant->isMyShop($uuid,$shop_id,$res);
            if ($res->code == 200 && $res->data == 1) {
                return true;
            }
        }
        return false;

    }
}
