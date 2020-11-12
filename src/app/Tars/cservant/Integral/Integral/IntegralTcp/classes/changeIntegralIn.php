<?php

namespace App\Tars\cservant\Integral\Integral\IntegralTcp\classes;

class changeIntegralIn extends \TARS_Struct {
	const MERCHANT_ID = 0;
	const PLATFORM_ID = 1;
	const INTEGRAL_TASK_ID = 2;
	const FROZEN_INTEGRAL_TOTAL = 3;
	const USER_ID = 4;
	const USER_PHONE = 5;


	public $merchant_id; 
	public $platform_id; 
	public $integral_task_id; 
	public $frozen_integral_total; 
	public $user_id; 
	public $user_phone; 


	protected static $_fields = array(
		self::MERCHANT_ID => array(
			'name'=>'merchant_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PLATFORM_ID => array(
			'name'=>'platform_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::INTEGRAL_TASK_ID => array(
			'name'=>'integral_task_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::FROZEN_INTEGRAL_TOTAL => array(
			'name'=>'frozen_integral_total',
			'required'=>true,
			'type'=>\TARS::INT32,
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
	);

	public function __construct() {
		parent::__construct('Integral_Integral_IntegralTcp_changeIntegralIn', self::$_fields);
	}
}
