<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp\classes;

class publicInParam extends \TARS_Struct {
	const COUPON_ID = 0;


	public $coupon_id; 


	protected static $_fields = array(
		self::COUPON_ID => array(
			'name'=>'coupon_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_publicInParam', self::$_fields);
	}
}
