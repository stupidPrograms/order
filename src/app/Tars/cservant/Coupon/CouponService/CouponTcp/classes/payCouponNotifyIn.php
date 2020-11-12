<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class payCouponNotifyIn extends \TARS_Struct {
	const ORDER_SN = 0;
	const COUPON_ID = 1;
	const PAY_MONEY = 2;


	public $order_sn; 
	public $coupon_id; 
	public $pay_money; 


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
		self::PAY_MONEY => array(
			'name'=>'pay_money',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_payCouponNotifyIn', self::$_fields);
	}
}
