<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class PosClerks extends \TARS_Struct {
	const ID = 0;
	const CODE = 1;
	const NICKNAME = 2;
	const CREATED_AT = 3;
	const REMARK = 4;


	public $id; 
	public $code; 
	public $nickname; 
	public $created_at; 
	public $remark; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NICKNAME => array(
			'name'=>'nickname',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CREATED_AT => array(
			'name'=>'created_at',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::REMARK => array(
			'name'=>'remark',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_PosClerks', self::$_fields);
	}
}
