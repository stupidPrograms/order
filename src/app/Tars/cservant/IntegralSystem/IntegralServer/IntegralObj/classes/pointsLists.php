<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes;

class pointsLists extends \TARS_Struct {
	const PAGE = 0;
	const TOTAL = 1;
	const DATA = 3;


	public $page; 
	public $total; 
	public $data; 


	protected static $_fields = array(
		self::PAGE => array(
			'name'=>'page',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TOTAL => array(
			'name'=>'total',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DATA => array(
			'name'=>'data',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_pointsLists', self::$_fields);
		$this->data = new \TARS_Vector(new pointsList());
	}
}
