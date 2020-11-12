<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class outSignContract extends \TARS_Struct {
	const BODY = 0;
	const MERCHANTNO = 1;
	const SIGN = 2;
	const INTERFACENAME = 3;
	const URL = 4;
	const CALLBACKURL = 5;


	public $body; 
	public $merchantNo; 
	public $sign; 
	public $interfaceName; 
	public $url; 
	public $callBackUrl; 


	protected static $_fields = array(
		self::BODY => array(
			'name'=>'body',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MERCHANTNO => array(
			'name'=>'merchantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SIGN => array(
			'name'=>'sign',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::INTERFACENAME => array(
			'name'=>'interfaceName',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::URL => array(
			'name'=>'url',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CALLBACKURL => array(
			'name'=>'callBackUrl',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_outSignContract', self::$_fields);
	}
}
