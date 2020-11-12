<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class UpdateParam extends \TARS_Struct {
	const TYPE = 0;
	const TOPRATE = 1;
	const TOPNEXTRATE = 2;
	const SECONDRATE = 3;
	const SECONDNEXTRATE = 4;
	const COMMODITYID = 5;


	public $type; 
	public $topRate; 
	public $topNextRate; 
	public $secondRate; 
	public $secondNextRate; 
	public $commodityId; 


	protected static $_fields = array(
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TOPRATE => array(
			'name'=>'topRate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TOPNEXTRATE => array(
			'name'=>'topNextRate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SECONDRATE => array(
			'name'=>'secondRate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SECONDNEXTRATE => array(
			'name'=>'secondNextRate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::COMMODITYID => array(
			'name'=>'commodityId',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_UpdateParam', self::$_fields);
		$this->commodityId = new \TARS_Vector(\TARS::INT32);
	}
}
