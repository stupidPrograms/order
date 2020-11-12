<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class outMyInfo extends \TARS_Struct {
	const TODAYINTEGRAL = 0;
	const TODAYTRANCOUNT = 1;
	const TRANCOUNT = 2;
	const AMOUNTCOUNT = 3;


	public $todayIntegral; 
	public $todayTranCount; 
	public $tranCount; 
	public $amountCount; 


	protected static $_fields = array(
		self::TODAYINTEGRAL => array(
			'name'=>'todayIntegral',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TODAYTRANCOUNT => array(
			'name'=>'todayTranCount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TRANCOUNT => array(
			'name'=>'tranCount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::AMOUNTCOUNT => array(
			'name'=>'amountCount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_personalObj_outMyInfo', self::$_fields);
	}
}
