<?php

namespace App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes;

class outMoney extends \TARS_Struct {
	const NOTMONEY = 0;
	const AVAMONEY = 1;
	const STAYMONEY = 2;


	public $notMoney; 
	public $avaMoney; 
	public $stayMoney; 


	protected static $_fields = array(
		self::NOTMONEY => array(
			'name'=>'notMoney',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::AVAMONEY => array(
			'name'=>'avaMoney',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STAYMONEY => array(
			'name'=>'stayMoney',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('OrderSystem_OrderServer_OrderObj_outMoney', self::$_fields);
	}
}
