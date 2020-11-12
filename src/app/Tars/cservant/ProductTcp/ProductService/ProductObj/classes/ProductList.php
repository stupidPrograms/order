<?php

namespace App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes;

class ProductList extends \TARS_Struct {
	const ITEM = 0;
	const TOTAL = 1;
	const CODE = 2;
	const MESSAGE = 3;


	public $item; 
	public $total; 
	public $code; 
	public $message; 


	protected static $_fields = array(
		self::ITEM => array(
			'name'=>'item',
			'required'=>false,
			'type'=>\TARS::VECTOR,
			),
		self::TOTAL => array(
			'name'=>'total',
			'required'=>false,
			'type'=>\TARS::INT32,
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
		parent::__construct('ProductTcp_ProductService_ProductObj_ProductList', self::$_fields);
		$this->item = new \TARS_Vector(new ProductInfo());
	}
}
