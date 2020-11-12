<?php

namespace App\Tars\servant\IntegralSystem\IntegralServer\IntegralObj\classes;

class OutOrderList extends \TARS_Struct {
	const TOTAL = 0;
	const ITEMS = 1;


	public $total; 
	public $items; 


	protected static $_fields = array(
		self::TOTAL => array(
			'name'=>'total',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ITEMS => array(
			'name'=>'items',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_OutOrderList', self::$_fields);
		$this->items = new \TARS_Vector(new OutOrderInfo());
	}
}
