<?php

namespace App\Tars\cservant\dist\distClient\distributorObj\classes;

class friendQrCode extends \TARS_Struct {
	const DISTID = 0;
	const CODE = 1;
	const BUSINESSID = 2;


	public $distId; 
	public $code; 
	public $businessId; 


	protected static $_fields = array(
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
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_distributorObj_friendQrCode', self::$_fields);
	}
}
