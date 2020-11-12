<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp\classes;

class inProductId extends \TARS_Struct {
	const PRODUCT_ID = 0;


	public $product_id; 


	protected static $_fields = array(
		self::PRODUCT_ID => array(
			'name'=>'product_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_inProductId', self::$_fields);
	}
}
