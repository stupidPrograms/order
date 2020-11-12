<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class buyCouponIn extends \TARS_Struct {
	const ORDER_SN = 0;
	const COUPON_ID = 1;
	const USER_ID = 2;
	const MOBILE = 3;
	const NUMBER = 4;
	const PRE_PAY_PRICE = 5;


	public $order_sn; 
	public $coupon_id; 
	public $user_id; 
	public $mobile; 
	public $number; 
	public $pre_pay_price; 


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
		self::USER_ID => array(
			'name'=>'user_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NUMBER => array(
			'name'=>'number',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PRE_PAY_PRICE => array(
			'name'=>'pre_pay_price',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_buyCouponIn', self::$_fields);
	}
}
