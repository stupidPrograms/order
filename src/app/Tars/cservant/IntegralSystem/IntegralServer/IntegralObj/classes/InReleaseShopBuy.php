<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes;

class InReleaseShopBuy extends \TARS_Struct {
	const SHOP_ID = 0;
	const POINTS = 1;
	const TYPE = 2;
	const MARK = 3;
	const ENV_DOMAIN_ID = 4;
	const ORDER_CODE = 5;


	public $shop_id; 
	public $points; 
	public $type; 
	public $mark; 
	public $env_domain_id; 
	public $order_code; 


	protected static $_fields = array(
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::POINTS => array(
			'name'=>'points',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MARK => array(
			'name'=>'mark',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ENV_DOMAIN_ID => array(
			'name'=>'env_domain_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ORDER_CODE => array(
			'name'=>'order_code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_InReleaseShopBuy', self::$_fields);
	}
}
