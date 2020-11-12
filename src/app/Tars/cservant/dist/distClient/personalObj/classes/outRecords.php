<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class outRecords extends \TARS_Struct {
	const TRANCOUNT = 0;
	const AMOUNTCOUNT = 1;
	const DATA = 2;
	const PAGE = 3;
	const TOTAL = 4;


	public $tranCount; 
	public $amountCount; 
	public $data; 
	public $page; 
	public $total; 


	protected static $_fields = array(
		self::TRANCOUNT => array(
			'name'=>'tranCount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::AMOUNTCOUNT => array(
			'name'=>'amountCount',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::DATA => array(
			'name'=>'data',
			'required'=>false,
			'type'=>\TARS::VECTOR,
			),
		self::PAGE => array(
			'name'=>'page',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::TOTAL => array(
			'name'=>'total',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_personalObj_outRecords', self::$_fields);
		$this->data = new \TARS_Vector(new productList());
	}
}
