<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class OutMechantOverage extends \TARS_Struct {
	const BALANCE = 0;
	const FROZENBALANCE = 1;


	public $balance; 
	public $frozenBalance; 


	protected static $_fields = array(
		self::BALANCE => array(
			'name'=>'balance',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::FROZENBALANCE => array(
			'name'=>'frozenBalance',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_OutMechantOverage', self::$_fields);
	}
}
