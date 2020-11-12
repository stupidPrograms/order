<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class AddClerk extends \TARS_Struct {
	const POS_ID = 0;
	const UUID = 1;
	const NICKNAME = 2;
	const HEADIMGURL = 3;
	const CODE = 4;


	public $pos_id; 
	public $uuid; 
	public $nickname; 
	public $headimgurl; 
	public $code; 


	protected static $_fields = array(
		self::POS_ID => array(
			'name'=>'pos_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NICKNAME => array(
			'name'=>'nickname',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::HEADIMGURL => array(
			'name'=>'headimgurl',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_AddClerk', self::$_fields);
	}
}
