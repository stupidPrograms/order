<?php

namespace App\Tars\servant\IntegralSystem\IntegralServer\IntegralObj\classes;

class InNotifyData extends \TARS_Struct {
	const ORDERSN = 0;
	const PAID = 1;


	public $ordersn; 
	public $paid; 


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
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_InNotifyData', self::$_fields);
	}
}
