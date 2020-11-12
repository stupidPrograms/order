<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp\classes;

class couponInfo extends \TARS_Struct {
	const COUPON_ID = 0;
	const PLATFORM_ID = 1;
	const MERCHANT_ID = 2;
	const COUPON_TITLE = 3;
	const COUPON_TITLE_SUB = 4;
	const COUPON_TID = 5;
	const LIMIT_AMOUNT = 6;
	const DISCOUNT_AMOUNT = 7;
	const SAVE_AMOUNT = 8;
	const COUPON_DESC = 9;
	const USE_SCENARIO = 10;
	const USE_DESC = 11;
	const USE_LIMIT = 12;
	const TOTAL_NUM = 13;
	const RECIPIENTS_NUM = 14;
	const NUMBER_OF_RECIPIENTS = 15;
	const ADD_USER_ID = 16;
	const START_TIME = 17;
	const END_TIME = 18;
	const STATUS = 19;
	const DEPOSIT_PRICE = 20;


	public $coupon_id; 
	public $platform_id; 
	public $merchant_id; 
	public $coupon_title; 
	public $coupon_title_sub; 
	public $coupon_tid; 
	public $limit_amount; 
	public $discount_amount; 
	public $save_amount; 
	public $coupon_desc; 
	public $use_scenario; 
	public $use_desc; 
	public $use_limit; 
	public $total_num; 
	public $recipients_num; 
	public $number_of_recipients; 
	public $add_user_id; 
	public $start_time; 
	public $end_time; 
	public $status; 
	public $deposit_price; 


	protected static $_fields = array(
		self::COUPON_ID => array(
			'name'=>'coupon_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PLATFORM_ID => array(
			'name'=>'platform_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MERCHANT_ID => array(
			'name'=>'merchant_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::COUPON_TITLE => array(
			'name'=>'coupon_title',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::COUPON_TITLE_SUB => array(
			'name'=>'coupon_title_sub',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::COUPON_TID => array(
			'name'=>'coupon_tid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::LIMIT_AMOUNT => array(
			'name'=>'limit_amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::DISCOUNT_AMOUNT => array(
			'name'=>'discount_amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SAVE_AMOUNT => array(
			'name'=>'save_amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::COUPON_DESC => array(
			'name'=>'coupon_desc',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::USE_SCENARIO => array(
			'name'=>'use_scenario',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::USE_DESC => array(
			'name'=>'use_desc',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::USE_LIMIT => array(
			'name'=>'use_limit',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TOTAL_NUM => array(
			'name'=>'total_num',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::RECIPIENTS_NUM => array(
			'name'=>'recipients_num',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::NUMBER_OF_RECIPIENTS => array(
			'name'=>'number_of_recipients',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ADD_USER_ID => array(
			'name'=>'add_user_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::START_TIME => array(
			'name'=>'start_time',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::END_TIME => array(
			'name'=>'end_time',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::DEPOSIT_PRICE => array(
			'name'=>'deposit_price',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Coupon_CouponService_CouponTcp_couponInfo', self::$_fields);
	}
}
