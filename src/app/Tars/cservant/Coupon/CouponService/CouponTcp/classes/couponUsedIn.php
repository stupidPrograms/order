<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class couponUsedIn extends \TARS_Struct {
	const ORDER_SN = 0;
	const COUPON_ID = 1;
	const GOODS_ID = 2;
	const GOODS_NAME = 3;
	const USER_ID = 4;
	const USER_NAME = 5;
	const USER_PHONE = 6;


	public $order_sn; 
	public $coupon_id; 
	public $goods_id; 
	public $goods_name; 
	public $user_id; 
	public $user_name; 
	public $user_phone; 


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
		self::GOODS_ID => array(
			'name'=>'goods_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::GOODS_NAME => array(
			'name'=>'goods_name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::USER_ID => array(
			'name'=>'user_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::USER_NAME => array(
			'name'=>'user_name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::USER_PHONE => array(
			'name'=>'user_phone',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_couponUsedIn', self::$_fields);
	}
}
