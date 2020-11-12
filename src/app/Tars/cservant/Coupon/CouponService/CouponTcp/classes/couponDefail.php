<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp\classes;

class couponDefail extends \TARS_Struct {
	const COUPON_NAME = 0;
	const AMOUNT = 1;
	const COUPON_TYPE = 2;
	const REDUCTION_MONEY = 3;
	const CONTENT = 4;
	const START_TIME = 5;
	const END_TIME = 6;
	const DOMAIN_ID = 7;
	const STATUS = 8;


	public $coupon_name; 
	public $amount; 
	public $coupon_type; 
	public $reduction_money; 
	public $content; 
	public $start_time; 
	public $end_time; 
	public $domain_id; 
	public $status; 


	protected static $_fields = array(
		self::COUPON_NAME => array(
			'name'=>'coupon_name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::COUPON_TYPE => array(
			'name'=>'coupon_type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::REDUCTION_MONEY => array(
			'name'=>'reduction_money',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CONTENT => array(
			'name'=>'content',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::START_TIME => array(
			'name'=>'start_time',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::END_TIME => array(
			'name'=>'end_time',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DOMAIN_ID => array(
			'name'=>'domain_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_couponDefail', self::$_fields);
	}
}
