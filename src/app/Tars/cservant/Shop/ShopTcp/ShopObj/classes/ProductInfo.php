<?php

namespace App\Tars\cservant\Shop\ShopTcp\ShopObj\classes;

class ProductInfo extends \TARS_Struct {
	const ID = 0;
	const THUMB = 1;
	const NAME = 2;
	const PRICE = 3;
	const STOCK = 4;
	const DESCRIBE = 5;
	const UNIT = 6;
	const GIFT_POINTS = 9;
	const GIFT_TYPE = 10;
	const STORE_ID = 11;
	const P_NAME = 12;
	const DEPOSIT = 13;
	const PRODUCT_TYPES = 14;
	const DETAILS = 15;


	public $id; 
	public $thumb; 
	public $name; 
	public $price; 
	public $stock; 
	public $describe; 
	public $unit; 
	public $gift_points; 
	public $gift_type; 
	public $store_id; 
	public $p_name; 
	public $deposit; 
	public $product_types; 
	public $details; 


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
		self::GIFT_POINTS => array(
			'name'=>'gift_points',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::GIFT_TYPE => array(
			'name'=>'gift_type',
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
		self::DEPOSIT => array(
			'name'=>'deposit',
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
	);

	public function __construct() {
		parent::__construct('Shop_ShopTcp_ShopObj_ProductInfo', self::$_fields);
	}
}
