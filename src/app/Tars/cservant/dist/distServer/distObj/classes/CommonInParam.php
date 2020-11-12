<?php

namespace App\Tars\cservant\dist\distServer\distObj\classes;

class CommonInParam extends \TARS_Struct {
	const BUSINESSID = 0;
	const DOMAINID = 1;
	const STOREID = 2;


	public $businessId; 
	public $domainId; 
	public $storeId; 


	protected static $_fields = array(
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::STOREID => array(
			'name'=>'storeId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_distObj_CommonInParam', self::$_fields);
	}
}
