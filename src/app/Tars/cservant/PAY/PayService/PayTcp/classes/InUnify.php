<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InUnify extends \TARS_Struct {
	const AMOUNT = 0;
	const MARK = 1;
	const REMARK = 2;
	const UUID = 3;
	const STATE = 4;
	const OPENID = 5;
	const VALIDAT = 6;
	const MERCHANTNO = 7;
	const TYPE = 8;
	const ORDERSN = 9;
	const STOREID = 10;
	const DOMAINID = 11;


	public $amount; 
	public $mark; 
	public $remark; 
	public $uuid; 
	public $state; 
	public $openid; 
	public $validat; 
	public $merchantNo; 
	public $type=1; 
	public $orderSn; 
	public $storeId; 
	public $doMainId; 


	protected static $_fields = array(
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MARK => array(
			'name'=>'mark',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::REMARK => array(
			'name'=>'remark',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STATE => array(
			'name'=>'state',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::OPENID => array(
			'name'=>'openid',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::VALIDAT => array(
			'name'=>'validat',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MERCHANTNO => array(
			'name'=>'merchantNo',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::ORDERSN => array(
			'name'=>'orderSn',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STOREID => array(
			'name'=>'storeId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DOMAINID => array(
			'name'=>'doMainId',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InUnify', self::$_fields);
	}
}
