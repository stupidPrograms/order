<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class Status extends \TARS_Struct {
	const ERR = 0;
	const MSG = 1;
	const CODE = 2;


	public $err; 
	public $msg; 
	public $code; 


	protected static $_fields = array(
		self::ERR => array(
			'name'=>'err',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MSG => array(
			'name'=>'msg',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_Status', self::$_fields);
	}
}
