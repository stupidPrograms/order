<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class outBusiness extends \TARS_Struct {
	const DATA = 0;
	const PAGE = 1;
	const TOTAL = 2;


	public $data; 
	public $page; 
	public $total; 


	protected static $_fields = array(
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
		parent::__construct('dist_distClient_personalObj_outBusiness', self::$_fields);
		$this->data = new \TARS_Vector(new business());
	}
}
