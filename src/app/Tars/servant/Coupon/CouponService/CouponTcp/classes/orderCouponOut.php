<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp\classes;

class orderCouponOut extends \TARS_Struct {
	const CODE = 0;
	const MESSAGE = 1;
	const COUPON_INFO = 2;


	public $code; 
	public $message; 
	public $coupon_info; 


	protected static $_fields = array(
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MESSAGE => array(
			'name'=>'message',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::COUPON_INFO => array(
			'name'=>'coupon_info',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_orderCouponOut', self::$_fields);
		$this->coupon_info = new \TARS_Vector(new couponDefail());
	}
}
