<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class PosApplyQuery extends \TARS_Struct {
	const SHOP_ID = 0;
	const SHOP_NAME = 1;
	const START_TIME = 2;
	const END_TIME = 3;


	public $shop_id; 
	public $shop_name; 
	public $start_time; 
	public $end_time; 


	protected static $_fields = array(
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::SHOP_NAME => array(
			'name'=>'shop_name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::START_TIME => array(
			'name'=>'start_time',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::END_TIME => array(
			'name'=>'end_time',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_Backend_PosApplyQuery', self::$_fields);
	}
}
