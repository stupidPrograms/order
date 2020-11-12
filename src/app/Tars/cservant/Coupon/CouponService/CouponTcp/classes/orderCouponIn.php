<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class orderCouponIn extends \TARS_Struct {
	const ORDER_SN = 0;
	const COUPON_ID = 1;
	const MONEY = 2;
	const MOBILE = 3;
	const NAME = 4;
	const GOODS_ID = 5;
	const SHOP_ID = 6;
	const IS_CHECK = 7;


	public $order_sn; 
	public $coupon_id; 
	public $money; 
	public $mobile; 
	public $name; 
	public $goods_id; 
	public $shop_id; 
	public $is_check; 


	protected static $_fields = array(
		self::ORDER_SN => array(
			'name'=>'order_sn',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::COUPON_ID => array(
			'name'=>'coupon_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MONEY => array(
			'name'=>'money',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NAME => array(
			'name'=>'name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::GOODS_ID => array(
			'name'=>'goods_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::IS_CHECK => array(
			'name'=>'is_check',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_orderCouponIn', self::$_fields);
	}
}
