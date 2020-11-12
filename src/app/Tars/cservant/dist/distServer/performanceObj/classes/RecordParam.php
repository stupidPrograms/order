<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class RecordParam extends \TARS_Struct {
	const TRANID = 0;
	const ORDER_SN = 1;
	const AMOUNT = 2;
	const RATE = 3;
	const DOMAINID = 4;
	const CODE = 5;
	const UUID = 6;
	const STOREID = 7;
	const COUNT = 8;
	const PAY_ONLINE = 9;


	public $tranId; 
	public $order_sn; 
	public $amount; 
	public $rate; 
	public $domainId; 
	public $code; 
	public $uuid; 
	public $storeId; 
	public $count; 
	public $pay_online; 


	protected static $_fields = array(
		self::TRANID => array(
			'name'=>'tranId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ORDER_SN => array(
			'name'=>'order_sn',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::RATE => array(
			'name'=>'rate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STOREID => array(
			'name'=>'storeId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::COUNT => array(
			'name'=>'count',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PAY_ONLINE => array(
			'name'=>'pay_online',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_RecordParam', self::$_fields);
	}
}
