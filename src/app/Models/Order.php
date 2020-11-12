<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use SoftDeletes;


    protected $table = 'orders';

    protected $fillable = [
        'uuid',
        'shop_id',
        'shop_name',
        'business_id',
        'money',
        'pay_online',
        'pay_offline',
        'surplus_money',
        'ordersn',
        'status',
        'order_source',
        'address',
        'recipient',
        'goods_id',
        'goods_type',
        'deposit',
        'phone',
        'store_mobile',
        'create_by_phone',
        'dist_code',
        'express_code',
        'channel_code',
        'poster_code',
        'group_code',
        'sale_code',
        'express_name',
        'status',
        'order_type',
        'paid',
        'paid_at',
        'remark',
        'gift_points',
        'pay_ordersn',
        'over_time',
        'env_domain_id',
        'hand_rate',
        'hand_cost',
        'sale_cost',
        'check_sett',
        'updated_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    const TYPE = [
        1   => '待核销',
        2   => '已核销',
    ];

    const ORDER_TYPE = [
        4   => '秒杀商品',
        6   => '定金券',
    ];

    //protected $appends = ["order_price_modified"];

    public function orderGoods(){
        return $this->hasMany(OrderGoods::class);
    }

    public function orderCoupon(){
        return $this->hasMany(OrderCoupon::class);
    }

    public function orderGood(){
        return $this->hasOne(OrderGoods::class,'order_id','id');
    }

    public function addOrders($data){
        return static::query()->create($data);
    }

    public static function orderInfo($id){
        return static::query()->where('id', $id)->with(['orderGoods'])->first();
    }

    //获取店铺订单列表
    public static function getShopOrderList($rows,$shop_id,$ordersn,$recipient,$phone,$goods_name,$order_type,$order_source,$status,$start,$end)
    {

        $queryBuilder = static::query();
        $queryBuilder->select('id', 'uuid', 'money', 'pay_online', 'pay_offline', 'shop_id','shop_name', 'ordersn', 'address', 'recipient', 'phone','store_mobile', 'express_code','create_by_phone',
            'status', 'order_source', 'paid', 'order_type', 'paid_at', 'gift_points','created_at', 'over_time', 'deleted_at','remark','comment')
            ->whereNotNull('status')->whereIn('shop_id', $shop_id)->with('orderGoods')
            ->whereHas('orderGoods',function ($q) use (&$goods_name){

                if ($goods_name) $q->where('goods_name', 'like', "%$goods_name%");

            })->where(function ($query){
                $query->whereRaw('order_type in (1, 2, 3, 4, 6) and status in (-5,-4,0,1,2,3,4,5)')
                    ->orWhereRaw('order_type = 5 and status in (-4,4) and group_success = 1');
            });
        if ($ordersn)       $queryBuilder->where('ordersn','like', "%$ordersn%");

        if ($recipient)     $queryBuilder->where('recipient','like', "%$recipient%");

        if ($phone)         $queryBuilder->where('phone','like', "%$phone%");

        if ($order_type == 2)    $queryBuilder->whereIn('order_type', [2,4,5,6]);

        if (!empty($order_source)) $queryBuilder->where('order_source', $order_source);

        if ($status == 3 || $status == -2)   {$queryBuilder->whereIn('status', [-2,3,4]);}  //已关闭，已完成，已核销
        elseif($status == -4)                {$queryBuilder->whereIn('status', [-5,-4,5]);}
        elseif(isset($status))               {$queryBuilder->where('status',$status);}

        if ($start)         $queryBuilder->where('created_at', '>=', $start);

        if ($end)           $queryBuilder->where('created_at', '<=', $end);

        $models = $queryBuilder->orderBy('created_at', 'desc')->paginate($rows);
        return $models;
    }

    //取得用户所下订单，加分页
    public static function getUserOrder($rows,$is_store,$uuid,$status,int $shopId = null,int $page = null)
    {
        $query = static::query()->select('id','shop_id','uuid','money', 'pay_online', 'pay_offline', 'ordersn','sale_code', 'pay_ordersn','address','order_type',
            'recipient','phone','store_mobile', 'express_code', 'status', 'paid', 'paid_at', 'gift_points','created_at', 'over_time','remark','comment')
            ->whereNotNull('status')->with('orderGoods')->whereHas('orderGoods')
            ->where(function ($query){
                $query->whereRaw('order_type in (1, 2, 3, 4, 6) and status in (-5,-4,0,1,2,3,4,5)')
                    ->orWhereRaw('order_type = 5 and status in (-4,4) and group_success = 1');
            });

        if ($shopId && $shopId != 0)    {$query->where('shop_id',$shopId);}

        //为1的时候，则为商家获取数据，不添加用户限制
        if($is_store == 0)  {$query->where('uuid', $uuid);}

        if (isset($status)){
            if($status == -4){
                $query->whereIn('status', [-5,-4,5]);
            }else{
                $query->where('status', $status);
            }
        }

        if ($page) $query->forPage($page,$rows);

        $query->orderBy('created_at', 'desc');
        return $query->paginate($rows);
    }

    //取得用户指定店铺id的订单列表
    public static function getUserShopOrder($uuid,$is_store,int $shopId, int $status=null, int $page=null, int $rows=null)
    {
        return static::getUserOrder($rows,$is_store,$uuid,$status,$shopId,$page);
    }


    public static function updateOrder($data, $ordersn, $pay_ordersn)
    {
        $query = static::query();

        if ($ordersn)   $query->where('ordersn', $ordersn);

        if ($pay_ordersn) $query->where('pay_ordersn', $pay_ordersn);


        return $query->update($data);
    }

    /**
     * @param $uuid
     * @param null $shop_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getStatusNum($uuid,$shop_id = null)
    {
//        return DB::table('orders')->select(DB::raw('count(status=0 OR NULL) as pay , count(status=1 OR NULL) as send, count(status=2 OR NULL) as receipt, count(status=-4 OR NULL) as write_off'))->get();
        $builder = static::query();

        if ($shop_id)   $builder->where('shop_id',$shop_id);

        if($uuid)   $builder->where('uuid', $uuid);

        $model  =   clone $builder;

        return $builder->selectRaw("
            count(paid=1    OR NULL)   as  whole,  
            count(status=0  AND order_type != 5  OR NULL)   as  pay, 
            count(status=1  OR NULL)   as  send,
            count(status=2  OR NULL)   as  receipt,
            count(status=3  OR NULL)   as  order_off,
            count(status in (-5,5) OR NULL)   as  write_off,
            count(status=4  OR NULL)   as  write_end"
        )->get()->each(function ($query) use (&$model){
            $total = $model->where(function ($item){
                $item->whereRaw('order_type != 5 and status = -4')->orWhereRaw('order_type = 5 and group_success = 1 and status = -4');
            })->count();
            $query->write_off   =   $query->write_off + $total;
        });
    }

    public static function getShopStatusNum($shop_id_arr)
    {
//        return DB::table('orders')->select(DB::raw('count(status=0 OR NULL) as pay , count(status=1 OR NULL) as send, count(status=2 OR NULL) as receipt, count(status=-4 OR NULL) as write_off'))->get();
        return static::query()->selectRaw('count(status=1 OR NULL) as express, count(status=-4 OR NULL) as write_off')
            ->whereIn('shop_id', $shop_id_arr)
            ->get();
    }

    public static function cancel($uuid, $order_id, $remark)
    {
        return static::query()->where('uuid', $uuid)->where('id', $order_id)->where('status', 0)->update(['status' => -2, 'remark' => $remark]);
    }

    public static function generateOrderSn(){
        return $ordersn = date('YmdHis').rand(100000, 999999);

    }

    //订单价格是否有更改过 的自定义属性
    public function getOrderPriceModifiedAttribute(){
        if (OrderRecord::query()->where('order_id',$this->id)->exists()) {
            return 1;
        }
        return 0;
    }

}
