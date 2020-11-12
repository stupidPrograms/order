<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHirePur extends Model{

    protected $table = 'order_hire_purchase';

    /**
     * 核销订单操作记录
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSaleInfo($id){
        return self::query()->where('order_id',$id)->orderBy('id','desc')->get();
    }
}
