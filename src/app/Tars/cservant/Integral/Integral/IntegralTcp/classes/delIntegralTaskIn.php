<?php

namespace App\Tars\cservant\Integral\Integral\IntegralTcp\classes;

class delIntegralTaskIn extends \TARS_Struct {
	const MERCHANT_ID = 0;
	const PLATFORM_ID = 1;
	const INTEGRAL_TASK_ID = 2;
	const TYPE = 3;


	public $merchant_id; 
	public $platform_id; 
	public $integral_task_id; 
	public $type; 


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
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Integral_Integral_IntegralTcp_delIntegralTaskIn', self::$_fields);
	}
}
