<?php

namespace App\Tars\cservant\Integral\Integral\IntegralTcp\classes;

class specialFrozenIntegralParam extends \TARS_Struct {
	const TITLE = 0;
	const MERCHANT_ID = 1;
	const USER_ID = 2;
	const USER_PHONE = 3;
	const FROZEN_TYPE = 4;
	const FROZEN_INTEGRAL_TOTAL = 5;
	const INTEGRAL_TASK_ID = 6;
	const END_TIME = 7;
	const PLATFORM_ID = 8;


	public $title; 
	public $merchant_id; 
	public $user_id; 
	public $user_phone; 
	public $frozen_type; 
	public $frozen_integral_total; 
	public $integral_task_id; 
	public $end_time; 
	public $platform_id; 


	protected static $_fields = array(
		self::TITLE => array(
			'name'=>'title',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MERCHANT_ID => array(
			'name'=>'merchant_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::USER_ID => array(
			'name'=>'user_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::USER_PHONE => array(
			'name'=>'user_phone',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::FROZEN_TYPE => array(
			'name'=>'frozen_type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::FROZEN_INTEGRAL_TOTAL => array(
			'name'=>'frozen_integral_total',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::INTEGRAL_TASK_ID => array(
			'name'=>'integral_task_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::END_TIME => array(
			'name'=>'end_time',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::PLATFORM_ID => array(
			'name'=>'platform_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Integral_Integral_IntegralTcp_specialFrozenIntegralParam', self::$_fields);
	}
}
