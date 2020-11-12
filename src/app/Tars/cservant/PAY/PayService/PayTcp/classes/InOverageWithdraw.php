<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InOverageWithdraw extends \TARS_Struct {
	const AMOUNT = 0;
	const MERCHANTNO = 1;


	public $amount; 
	public $merchantNo; 


	protected static $_fields = array(
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MERCHANTNO => array(
			'name'=>'merchantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InOverageWithdraw', self::$_fields);
	}
}
