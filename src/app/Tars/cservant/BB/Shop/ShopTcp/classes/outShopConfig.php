<?php

namespace App\Tars\cservant\BB\Shop\ShopTcp\classes;

class outShopConfig extends \TARS_Struct {
	const ID = 0;
	const APP_ID = 1;
	const SECRET = 2;
	const MCH_ID = 3;
	const KEY = 4;


	public $id; 
	public $app_id; 
	public $secret; 
	public $mch_id; 
	public $key; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::APP_ID => array(
			'name'=>'app_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SECRET => array(
			'name'=>'secret',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MCH_ID => array(
			'name'=>'mch_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::KEY => array(
			'name'=>'key',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_Shop_ShopTcp_outShopConfig', self::$_fields);
	}
}
