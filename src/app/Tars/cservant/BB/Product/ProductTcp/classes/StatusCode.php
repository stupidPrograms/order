<?php

namespace App\Tars\cservant\BB\Product\ProductTcp\classes;

class StatusCode extends \TARS_Struct {
	const CODE = 0;
	const MESSAGE = 1;
	const DATA = 2;


	public $code; 
	public $message; 
	public $data; 


	protected static $_fields = array(
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
		self::DATA => array(
			'name'=>'data',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_Product_ProductTcp_StatusCode', self::$_fields);
	}
}
