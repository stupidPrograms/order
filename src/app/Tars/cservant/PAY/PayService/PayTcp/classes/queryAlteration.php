<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class queryAlteration extends \TARS_Struct {
	const ORDERNO = 0;
	const MERCHANTNO = 1;
	const TYPE = 1;


	public $orderNo; 
	public $merchantNo; 
	public $type; 


	protected static $_fields = array(
		self::ORDERNO => array(
			'name'=>'orderNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MERCHANTNO => array(
			'name'=>'merchantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_queryAlteration', self::$_fields);
	}
}
