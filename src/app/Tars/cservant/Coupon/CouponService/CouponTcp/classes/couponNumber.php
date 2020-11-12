<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class couponNumber extends \TARS_Struct {
	const NUMBER = 0;


	public $number; 


	protected static $_fields = array(
		self::NUMBER => array(
			'name'=>'number',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_couponNumber', self::$_fields);
	}
}
