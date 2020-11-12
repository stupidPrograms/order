<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderGoods extends Model
{
    use SoftDeletes;

    protected $table = 'orders_goods';

    protected $fillable = [
        'order_id',
        'goods_id',
        'goods_name',
        'sku_id',
        'attr_name',
        'price',
        'thumb',
        'num',
        'ordersn',
        'store_id',
        'cost'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function addOrderGoods($data)
    {
        return $this->create($data);
    }

    public function getShopOrderList($rows,$uuid,$shop_id,$start,$end,$order_id)
    {
        $query = $this->select('*')->where('store_id', $shop_id)
            ->with(['order'=> function($q){
                $q->select('id');
            }]);
        if ($uuid){
            $query->where('uuid', $uuid);
        }
        if ($start){
            $query->where('created_at', '>=', $start);
        }
        if ($end){
            $query->where('created_at', '<=', $end);
        }
        if ($order_id){
            $query->where('id', $order_id);
        }
        return $query->paginate($rows);
    }
}
