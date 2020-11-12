<?php

namespace App\Tars\cservant\Integral\Integral\IntegralTcp\classes;

class merchantAddSalesmanParam extends \TARS_Struct {
	const MERCHANT_UUID = 0;
	const SHOP_ID = 1;
	const CONSUM_TYPE = 2;
	const INTEGRAL_NUM = 3;


	public $merchant_uuid; 
	public $shop_id; 
	public $consum_type; 
	public $integral_num; 


	protected static $_fields = array(
		self::MERCHANT_UUID => array(
			'name'=>'merchant_uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CONSUM_TYPE => array(
			'name'=>'consum_type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::INTEGRAL_NUM => array(
			'name'=>'integral_num',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Integral_Integral_IntegralTcp_merchantAddSalesmanParam', self::$_fields);
	}
}
