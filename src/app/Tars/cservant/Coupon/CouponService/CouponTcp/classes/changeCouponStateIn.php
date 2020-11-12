<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class changeCouponStateIn extends \TARS_Struct {
	const ORDER_SN = 0;
	const STATE = 1;


	public $order_sn; 
	public $state; 


	protected static $_fields = array(
		self::ORDER_SN => array(
			'name'=>'order_sn',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STATE => array(
			'name'=>'state',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_changeCouponStateIn', self::$_fields);
	}
}
