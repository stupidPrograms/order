<?php

namespace App\Tars\servant\Shop\ShopTcp\ShopObj\classes;

class outProductList extends \TARS_Struct {
	const ITEM = 0;
	const TOTAL = 1;


	public $item; 
	public $total; 


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
	);

	public function __construct() {
		parent::__construct('Shop_ShopTcp_ShopObj_outProductList', self::$_fields);
		$this->item = new \TARS_Vector(new ProductInfo());
	}
}
