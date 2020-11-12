<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp\classes;

class availableCouponInfo extends \TARS_Struct {
	const COUPON_INFO = 0;
	const PAGE = 1;
	const ROWS = 2;
	const TOTAL = 3;
	const CODE = 4;


	public $coupon_info; 
	public $page; 
	public $rows; 
	public $total; 
	public $code; 


	protected static $_fields = array(
		self::COUPON_INFO => array(
			'name'=>'coupon_info',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::PAGE => array(
			'name'=>'page',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ROWS => array(
			'name'=>'rows',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TOTAL => array(
			'name'=>'total',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_availableCouponInfo', self::$_fields);
		$this->coupon_info = new \TARS_Vector(new couponInfo());
	}
}
