<?php

namespace App\Tars\cservant\BB\Product\ProductTcp\classes;

class UpdateData extends \TARS_Struct {
	const ID = 0;
	const NUM = 1;
	const ATTR_ID = 2;
	const ORDER_ID = 3;
	const TYPE = 4;
	const REMARKS = 5;


	public $id; 
	public $num; 
	public $attr_id; 
	public $order_id; 
	public $type; 
	public $remarks; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::NUM => array(
			'name'=>'num',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ATTR_ID => array(
			'name'=>'attr_id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::ORDER_ID => array(
			'name'=>'order_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::REMARKS => array(
			'name'=>'remarks',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_Product_ProductTcp_UpdateData', self::$_fields);
	}
}
