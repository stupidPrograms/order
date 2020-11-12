<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderEvent extends Model
{
    //事件类型，0 创建订单请求（未扣除库存） 1 已扣除库存（未付款） 2 已创建支付订单未付款 3 已付款
    const ORDER_CREATED = 0;
    const STOCK_DEDUCTED = 1;
    const ORDER_UNPAID = 2;
    const ORDER_PAID = 3;
    const ORDER_CLOSED = 4;
    //数据库字段必须动态设定
//    private $order_sn;
//    private $event;

    const CREATED_AT =  null;
    const UPDATED_AT = null;


    public static function setEvent($orderSn, $eventType) {
        switch ($eventType) {
            case self::ORDER_CREATED:
                $order = new static();
                $order->order_sn = $orderSn;
                $order->event    = $eventType;
                $order->saveOrFail();
                return;
            case self::STOCK_DEDUCTED:
            case self::ORDER_UNPAID:
            case self::ORDER_PAID:
                $order = static::query()->where('order_sn',$orderSn)->firstOrFail();
                $order->event = $eventType;
                $order->saveOrFail();
                return;
        }
    }

    public static function getStatus($orderSn) {
        /** @var self $order */
        $order = static::query()->where('order_sn',$orderSn)->first();
        return $order ? $order->event : null;
    }
}
