<?php

namespace App\Tars\cservant\Integral\Integral\IntegralTcp\classes;

class inReturnIntegral extends \TARS_Struct {
	const INTEGRAL_TASK_ID = 0;
	const MERCHANT_ID = 1;
	const PLATFORM_ID = 2;


	public $integral_task_id; 
	public $merchant_id; 
	public $platform_id; 


	protected static $_fields = array(
		self::INTEGRAL_TASK_ID => array(
			'name'=>'integral_task_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
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
	);

	public function __construct() {
		parent::__construct('Integral_Integral_IntegralTcp_inReturnIntegral', self::$_fields);
	}
}
