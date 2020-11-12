<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes;

class myPoints extends \TARS_Struct {
	const POINTS = 0;
	const NOTPOINTS = 1;
	const LOADPOINTS = 2;


	public $points; 
	public $notPoints; 
	public $loadPoints; 


	protected static $_fields = array(
		self::POINTS => array(
			'name'=>'points',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NOTPOINTS => array(
			'name'=>'notPoints',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::LOADPOINTS => array(
			'name'=>'loadPoints',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_myPoints', self::$_fields);
	}
}
