<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class inputUpgrade extends \TARS_Struct {
	const UUID = 0;
	const STORE_ID = 1;
	const DOMAINID = 2;
	const MONEY = 3;


	public $uuid; 
	public $store_id; 
	public $domainId; 
	public $money; 


	protected static $_fields = array(
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STORE_ID => array(
			'name'=>'store_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MONEY => array(
			'name'=>'money',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_inputUpgrade', self::$_fields);
	}
}
