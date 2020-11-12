<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class Config extends \TARS_Struct {
	const RATE = 0;
	const NEXTRATE = 1;
	const LEVEL = 2;


	public $rate; 
	public $nextRate; 
	public $level; 


	protected static $_fields = array(
		self::RATE => array(
			'name'=>'rate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NEXTRATE => array(
			'name'=>'nextRate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::LEVEL => array(
			'name'=>'level',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_Config', self::$_fields);
	}
}
