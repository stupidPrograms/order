<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes;

class inputintegra extends \TARS_Struct {
	const TYPE = 0;
	const START = 1;
	const END = 3;
	const PAGE = 4;


	public $type; 
	public $start; 
	public $end; 
	public $page; 


	protected static $_fields = array(
		self::TYPE => array(
			'name'=>'type',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::START => array(
			'name'=>'start',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::END => array(
			'name'=>'end',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PAGE => array(
			'name'=>'page',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_inputintegra', self::$_fields);
	}
}
