<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class quickPassFeesInfo extends \TARS_Struct {
	const QPBEGINVALUE = 0;
	const QPENDVALUE = 1;
	const QPFEE = 2;


	public $qpBeginValue; 
	public $qpEndValue; 
	public $qpFee; 


	protected static $_fields = array(
		self::QPBEGINVALUE => array(
			'name'=>'qpBeginValue',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::QPENDVALUE => array(
			'name'=>'qpEndValue',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::QPFEE => array(
			'name'=>'qpFee',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_quickPassFeesInfo', self::$_fields);
	}
}
