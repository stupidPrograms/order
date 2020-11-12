<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InSWIPE extends \TARS_Struct {
	const MERCHANTNO = 0;
	const AUTHCODE = 1;
	const AMOUNT = 2;
	const NOTIFYURL = 3;
	const STOREID = 4;


	public $merchantNo; 
	public $authCode; 
	public $amount; 
	public $notifyUrl; 
	public $storeId; 


	protected static $_fields = array(
		self::MERCHANTNO => array(
			'name'=>'merchantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::AUTHCODE => array(
			'name'=>'authCode',
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
		self::STOREID => array(
			'name'=>'storeId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InSWIPE', self::$_fields);
	}
}
