<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class amounts extends \TARS_Struct {
	const POINT = 0;
	const ID = 1;
	const UUID = 2;


	public $point; 
	public $id; 
	public $uuid; 


	protected static $_fields = array(
		self::POINT => array(
			'name'=>'point',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_amounts', self::$_fields);
	}
}
