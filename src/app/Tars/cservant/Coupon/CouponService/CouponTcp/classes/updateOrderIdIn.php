<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class updateOrderIdIn extends \TARS_Struct {
	const ORDER_SN = 0;
	const ORDER_ID = 1;
	const UUID = 2;


	public $order_sn; 
	public $order_id; 
	public $uuid; 


	protected static $_fields = array(
		self::ORDER_SN => array(
			'name'=>'order_sn',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ORDER_ID => array(
			'name'=>'order_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_updateOrderIdIn', self::$_fields);
	}
}
