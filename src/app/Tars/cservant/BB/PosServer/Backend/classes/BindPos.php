<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class BindPos extends \TARS_Struct {
	const PLATFORM = 0;
	const SHOP_ID = 1;
	const CODE = 2;


	public $platform; 
	public $shop_id; 
	public $code; 


	protected static $_fields = array(
		self::PLATFORM => array(
			'name'=>'platform',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_Backend_BindPos', self::$_fields);
	}
}
