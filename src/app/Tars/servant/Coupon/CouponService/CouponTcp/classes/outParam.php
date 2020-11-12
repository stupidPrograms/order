<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp\classes;

class outParam extends \TARS_Struct {
	const CODE = 0;
	const MESSAGE = 1;


	public $code; 
	public $message; 


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
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_outParam', self::$_fields);
	}
}
