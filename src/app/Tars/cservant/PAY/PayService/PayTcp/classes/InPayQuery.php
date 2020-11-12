<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InPayQuery extends \TARS_Struct {
	const MERCHANTNO = 0;
	const ORDERID = 1;


	public $merchantNo; 
	public $orderId; 


	protected static $_fields = array(
		self::MERCHANTNO => array(
			'name'=>'merchantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ORDERID => array(
			'name'=>'orderId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InPayQuery', self::$_fields);
	}
}
