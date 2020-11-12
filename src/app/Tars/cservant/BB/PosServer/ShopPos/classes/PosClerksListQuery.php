<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class PosClerksListQuery extends \TARS_Struct {
	const NICKNAME = 0;
	const START_TIME = 1;
	const END_TIME = 2;
	const POS_ID = 3;


	public $nickname; 
	public $start_time; 
	public $end_time; 
	public $pos_id; 


	protected static $_fields = array(
		self::NICKNAME => array(
			'name'=>'nickname',
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
		self::POS_ID => array(
			'name'=>'pos_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_PosClerksListQuery', self::$_fields);
	}
}
