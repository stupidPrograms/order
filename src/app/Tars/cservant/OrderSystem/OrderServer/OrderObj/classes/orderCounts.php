<?php

namespace App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes;

class orderCounts extends \TARS_Struct {
	const ORDERCOUNT = 0;
	const SELLCOUNT = 1;
	const GOODSCOUNT = 2;


	public $orderCount; 
	public $sellCount; 
	public $goodsCount; 


	protected static $_fields = array(
		self::ORDERCOUNT => array(
			'name'=>'orderCount',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SELLCOUNT => array(
			'name'=>'sellCount',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::GOODSCOUNT => array(
			'name'=>'goodsCount',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('OrderSystem_OrderServer_OrderObj_orderCounts', self::$_fields);
	}
}
