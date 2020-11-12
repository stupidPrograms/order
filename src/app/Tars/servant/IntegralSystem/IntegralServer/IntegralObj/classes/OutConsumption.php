<?php

namespace App\Tars\servant\IntegralSystem\IntegralServer\IntegralObj\classes;

class OutConsumption extends \TARS_Struct {
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
			'type'=>\TARS::FLOAT,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_OutConsumption', self::$_fields);
	}
}
