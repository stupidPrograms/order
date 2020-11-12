<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes;

class InWriteOffGive extends \TARS_Struct {
	const UUID = 0;
	const SHOP_ID = 1;
	const POINTS = 2;
	const ORDER_CODE = 3;


	public $uuid; 
	public $shop_id; 
	public $points; 
	public $order_code; 


	protected static $_fields = array(
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::POINTS => array(
			'name'=>'points',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ORDER_CODE => array(
			'name'=>'order_code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_InWriteOffGive', self::$_fields);
	}
}
