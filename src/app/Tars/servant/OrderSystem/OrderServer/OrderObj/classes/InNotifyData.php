<?php

namespace App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes;

class InNotifyData extends \TARS_Struct {
	const ORDERSN = 0;
	const PAID = 1;
	const PAID_TYPE = 2;


	public $ordersn; 
	public $paid; 
	public $paid_type; 


	protected static $_fields = array(
		self::ORDERSN => array(
			'name'=>'ordersn',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PAID => array(
			'name'=>'paid',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PAID_TYPE => array(
			'name'=>'paid_type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('OrderSystem_OrderServer_OrderObj_InNotifyData', self::$_fields);
	}
}
