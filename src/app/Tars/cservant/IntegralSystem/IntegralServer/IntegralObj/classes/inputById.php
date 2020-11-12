<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes;

class inputById extends \TARS_Struct {
	const UUID = 0;
	const SHOP_ID = 1;
	const DOMAINID = 3;


	public $uuid; 
	public $shop_id; 
	public $domainId; 


	protected static $_fields = array(
		self::UUID => array(
			'name'=>'uuid',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_inputById', self::$_fields);
	}
}
