<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes;

class pointsList extends \TARS_Struct {
	const ID = 0;
	const SHOP_ID = 1;
	const MARK = 2;
	const WHY = 3;
	const TYPE = 4;
	const CODE = 5;
	const POINTS = 7;
	const CHANGE_TYPE = 6;
	const CREATED_AT = 8;


	public $id; 
	public $shop_id; 
	public $mark; 
	public $why; 
	public $type; 
	public $code; 
	public $points; 
	public $change_type; 
	public $created_at; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MARK => array(
			'name'=>'mark',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::WHY => array(
			'name'=>'why',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::POINTS => array(
			'name'=>'points',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CHANGE_TYPE => array(
			'name'=>'change_type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CREATED_AT => array(
			'name'=>'created_at',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_pointsList', self::$_fields);
	}
}
