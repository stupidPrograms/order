<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class Daily extends \TARS_Struct {
	const AMOUNT = 0;
	const COUNT = 1;
	const DATE = 2;


	public $amount; 
	public $count; 
	public $date; 


	protected static $_fields = array(
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::COUNT => array(
			'name'=>'count',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::DATE => array(
			'name'=>'date',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_Daily', self::$_fields);
	}
}
