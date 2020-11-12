<?php

namespace App\Tars\cservant\dist\distClient\distributorObj\classes;

class inputQrCode extends \TARS_Struct {
	const GOODID = 0;
	const DOMAINID = 1;
	const BUSINESSID = 2;
	const DISTID = 3;
	const CODE = 4;
	const TYPE = 5;


	public $goodId; 
	public $domainId; 
	public $businessId; 
	public $distId; 
	public $code; 
	public $type; 


	protected static $_fields = array(
		self::GOODID => array(
			'name'=>'goodId',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DISTID => array(
			'name'=>'distId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_distributorObj_inputQrCode', self::$_fields);
	}
}
