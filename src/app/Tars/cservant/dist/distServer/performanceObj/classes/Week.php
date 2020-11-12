<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class Week extends \TARS_Struct {
	const SALES = 0;
	const SALEPERCENT = 1;
	const ORDERS = 2;
	const ORDERPERCENT = 3;
	const SUCCESS = 4;
	const SUCCESSPERCENT = 5;
	const USED = 6;
	const USEDPERCENT = 7;


	public $sales; 
	public $salePercent; 
	public $orders; 
	public $orderPercent; 
	public $success; 
	public $successPercent; 
	public $used; 
	public $usedPercent; 


	protected static $_fields = array(
		self::SALES => array(
			'name'=>'sales',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SALEPERCENT => array(
			'name'=>'salePercent',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ORDERS => array(
			'name'=>'orders',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ORDERPERCENT => array(
			'name'=>'orderPercent',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SUCCESS => array(
			'name'=>'success',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SUCCESSPERCENT => array(
			'name'=>'successPercent',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::USED => array(
			'name'=>'used',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::USEDPERCENT => array(
			'name'=>'usedPercent',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_Week', self::$_fields);
	}
}
