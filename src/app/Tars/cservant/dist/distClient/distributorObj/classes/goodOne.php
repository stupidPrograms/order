<?php

namespace App\Tars\cservant\dist\distClient\distributorObj\classes;

class goodOne extends \TARS_Struct {
	const USERID = 0;
	const BUSINESSID = 1;
	const GOODID = 2;
	const DOMAINID = 3;


	public $userId; 
	public $businessId; 
	public $goodId; 
	public $domainId; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
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
	);

	public function __construct() {
		parent::__construct('dist_distClient_distributorObj_goodOne', self::$_fields);
	}
}
