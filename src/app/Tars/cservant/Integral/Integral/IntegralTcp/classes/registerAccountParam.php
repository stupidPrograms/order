<?php

namespace App\Tars\cservant\Integral\Integral\IntegralTcp\classes;

class registerAccountParam extends \TARS_Struct {
	const PLATFORM_ID = 0;
	const MERCHANT_ID = 1;


	public $platform_id; 
	public $merchant_id; 


	protected static $_fields = array(
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
	);

	public function __construct() {
		parent::__construct('Integral_Integral_IntegralTcp_registerAccountParam', self::$_fields);
	}
}
