<?php

namespace App\Tars\cservant\BB\Shop\ShopTcp\classes;

class ShopList extends \TARS_Struct {
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
		parent::__construct('BB_Shop_ShopTcp_ShopList', self::$_fields);
		$this->item = new \TARS_Vector(new ShopInfo());
	}
}
