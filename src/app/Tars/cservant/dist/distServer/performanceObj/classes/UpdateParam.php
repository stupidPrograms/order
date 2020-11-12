<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class UpdateParam extends \TARS_Struct {
	const TRANID = 0;
	const STATUS = 1;
	const BUSINESSID = 2;
	const POINTS = 3;


	public $tranId; 
	public $status; 
	public $businessId; 
	public $points; 


	protected static $_fields = array(
		self::TRANID => array(
			'name'=>'tranId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::POINTS => array(
			'name'=>'points',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_UpdateParam', self::$_fields);
	}
}
