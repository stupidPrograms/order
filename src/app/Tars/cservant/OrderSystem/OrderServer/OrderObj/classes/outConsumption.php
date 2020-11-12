<?php

namespace App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes;

class outConsumption extends \TARS_Struct {
	const TOTAL = 0;
	const AMOUNT = 1;


	public $total; 
	public $amount; 


	protected static $_fields = array(
		self::TOTAL => array(
			'name'=>'total',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('OrderSystem_OrderServer_OrderObj_outConsumption', self::$_fields);
	}
}
