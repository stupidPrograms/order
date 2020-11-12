<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp\classes;

class singleCouponInfo extends \TARS_Struct {
	const COUPON_INFO = 0;
	const CODE = 1;


	public $coupon_info; 
	public $code; 


	protected static $_fields = array(
		self::COUPON_INFO => array(
			'name'=>'coupon_info',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_singleCouponInfo', self::$_fields);
		$this->coupon_info = new \TARS_Vector(new couponInfo());
	}
}
