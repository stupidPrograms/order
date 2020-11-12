<?php

namespace App\Tars\cservant\BB\Product\ProductTcp\classes;

class ProductInfo extends \TARS_Struct {
	const ID = 0;
	const THUMB = 1;
	const NAME = 2;
	const PRICE = 3;
	const STOCK = 4;
	const DESCRIBE = 5;
	const UNIT = 6;
	const CODE = 7;
	const MESSAGE = 8;
	const STORE_ID = 9;
	const P_NAME = 10;
	const PRODUCT_TYPES = 11;
	const DETAILS = 12;
	const CREATED_AT = 13;
	const UPDATED_AT = 14;


	public $id; 
	public $thumb; 
	public $name; 
	public $price; 
	public $stock; 
	public $describe; 
	public $unit; 
	public $code; 
	public $message; 
	public $store_id; 
	public $p_name; 
	public $product_types; 
	public $details; 
	public $created_at; 
	public $updated_at; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::THUMB => array(
			'name'=>'thumb',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::NAME => array(
			'name'=>'name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STOCK => array(
			'name'=>'stock',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::DESCRIBE => array(
			'name'=>'describe',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::UNIT => array(
			'name'=>'unit',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::MESSAGE => array(
			'name'=>'message',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STORE_ID => array(
			'name'=>'store_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::P_NAME => array(
			'name'=>'p_name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PRODUCT_TYPES => array(
			'name'=>'product_types',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DETAILS => array(
			'name'=>'details',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CREATED_AT => array(
			'name'=>'created_at',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::UPDATED_AT => array(
			'name'=>'updated_at',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_Product_ProductTcp_ProductInfo', self::$_fields);
	}
}
