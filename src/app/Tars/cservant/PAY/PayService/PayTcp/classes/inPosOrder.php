<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class inPosOrder extends \TARS_Struct {
	const CUSTOMERNUMB = 0;
	const ORDERID = 1;


	public $customerNumb; 
	public $orderId; 


	protected static $_fields = array(
		self::CUSTOMERNUMB => array(
			'name'=>'customerNumb',
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
		parent::__construct('PAY_PayService_PayTcp_inPosOrder', self::$_fields);
	}
}
