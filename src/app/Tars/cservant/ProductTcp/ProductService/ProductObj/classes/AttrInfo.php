<?php

namespace App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes;

class AttrInfo extends \TARS_Struct {
	const PRODUCT_ID = 0;
	const PRICE = 1;
	const COST = 2;
	const STOCK = 3;
	const NAME = 4;
	const WEIGHT = 5;
	const IMAGE = 6;
	const CODE = 7;
	const MESSAGE = 8;


	public $product_id; 
	public $price; 
	public $cost; 
	public $stock; 
	public $name; 
	public $weight; 
	public $image; 
	public $code; 
	public $message; 


	protected static $_fields = array(
		self::PRODUCT_ID => array(
			'name'=>'product_id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::COST => array(
			'name'=>'cost',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STOCK => array(
			'name'=>'stock',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::NAME => array(
			'name'=>'name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::WEIGHT => array(
			'name'=>'weight',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::IMAGE => array(
			'name'=>'image',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MESSAGE => array(
			'name'=>'message',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('ProductTcp_ProductService_ProductObj_AttrInfo', self::$_fields);
	}
}
