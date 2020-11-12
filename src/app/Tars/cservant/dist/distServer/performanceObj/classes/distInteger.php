<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class distInteger extends \TARS_Struct {
	const STORE_ID = 0;
	const ONE_DIST = 1;
	const TWO_DIST = 2;
	const ONE_INTEGER = 3;
	const TWO_INTEGER = 4;
	const DOMAINID = 5;
	const TASK_CODE = 6;


	public $store_id; 
	public $one_dist; 
	public $two_dist; 
	public $one_integer; 
	public $two_integer; 
	public $domainId; 
	public $task_code; 


	protected static $_fields = array(
		self::STORE_ID => array(
			'name'=>'store_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ONE_DIST => array(
			'name'=>'one_dist',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TWO_DIST => array(
			'name'=>'two_dist',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ONE_INTEGER => array(
			'name'=>'one_integer',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::TWO_INTEGER => array(
			'name'=>'two_integer',
			'required'=>false,
			'type'=>\TARS::FLOAT,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TASK_CODE => array(
			'name'=>'task_code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_distInteger', self::$_fields);
	}
}
