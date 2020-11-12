<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InDeviceTerminal extends \TARS_Struct {
	const CUSTOMERNUMBER = 0;
	const TERMNO = 1;


	public $customerNumber; 
	public $termNo; 


	protected static $_fields = array(
		self::CUSTOMERNUMBER => array(
			'name'=>'customerNumber',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TERMNO => array(
			'name'=>'termNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InDeviceTerminal', self::$_fields);
	}
}
