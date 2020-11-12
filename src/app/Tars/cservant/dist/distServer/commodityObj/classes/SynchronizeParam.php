<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class SynchronizeParam extends \TARS_Struct {
	const GOODID = 0;
	const DOMAINID = 1;
	const BUSINESSID = 2;
	const STOREID = 3;


	public $goodId; 
	public $domainId; 
	public $businessId; 
	public $storeId; 


	protected static $_fields = array(
		self::GOODID => array(
			'name'=>'goodId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STOREID => array(
			'name'=>'storeId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_SynchronizeParam', self::$_fields);
	}
}
