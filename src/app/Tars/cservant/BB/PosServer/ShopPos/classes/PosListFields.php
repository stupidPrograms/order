<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class PosListFields extends \TARS_Struct {
	const ID = 0;
	const CODE = 1;
	const TYPE = 2;
	const SHOP_NAME = 3;
	const CREATED_AT = 4;
	const PRICE = 5;
	const CARD = 6;


	public $id; 
	public $code; 
	public $type; 
	public $shop_name; 
	public $created_at; 
	public $price; 
	public $card; 


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
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SHOP_NAME => array(
			'name'=>'shop_name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CREATED_AT => array(
			'name'=>'created_at',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CARD => array(
			'name'=>'card',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_PosListFields', self::$_fields);
	}
}
