<?php

namespace App\Tars\cservant\dist\distServer\configObj\classes;

class Level extends \TARS_Struct {
	const LEVEL = 0;
	const TITLE = 1;
	const RATE = 2;
	const NEXTRATE = 3;
	const ADVANCEVALUE = 4;


	public $level; 
	public $title; 
	public $rate; 
	public $nextRate; 
	public $advanceValue; 


	protected static $_fields = array(
		self::LEVEL => array(
			'name'=>'level',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TITLE => array(
			'name'=>'title',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
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
		self::ADVANCEVALUE => array(
			'name'=>'advanceValue',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_configObj_Level', self::$_fields);
	}
}
