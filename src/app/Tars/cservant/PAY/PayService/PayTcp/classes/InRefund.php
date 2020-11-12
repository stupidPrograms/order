<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InRefund extends \TARS_Struct {
	const MERCHANTNO = 0;
	const ORDERID = 1;
	const AMOUNT = 2;
	const NOTIFYURL = 3;


	public $merchantNo; 
	public $orderId; 
	public $amount; 
	public $notifyUrl; 


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
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::NOTIFYURL => array(
			'name'=>'notifyUrl',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InRefund', self::$_fields);
	}
}
