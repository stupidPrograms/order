<?php

namespace App\Tars\cservant\dist\distServer\configObj\classes;

class QueryParam extends \TARS_Struct {
	const TOPTITLE = 0;
	const TOPRATE = 1;
	const TOPNEXTRATE = 2;
	const SECONDTITLE = 3;
	const SECONDRATE = 4;
	const SECONDNEXTRATE = 5;
	const ADVANCEVALUE = 6;
	const TYPE = 7;


	public $topTitle; 
	public $topRate; 
	public $topNextRate; 
	public $secondTitle; 
	public $secondRate; 
	public $secondNextRate; 
	public $advanceValue; 
	public $type; 


	protected static $_fields = array(
		self::TOPTITLE => array(
			'name'=>'topTitle',
			'required'=>true,
			'type'=>\TARS::STRING,
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
		self::SECONDTITLE => array(
			'name'=>'secondTitle',
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
		self::ADVANCEVALUE => array(
			'name'=>'advanceValue',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_configObj_QueryParam', self::$_fields);
	}
}
