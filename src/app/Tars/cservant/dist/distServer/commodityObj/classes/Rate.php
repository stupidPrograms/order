<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class Rate extends \TARS_Struct {
	const TYPE = 0;
	const DATA = 1;


	public $type; 
	public $data; 


	protected static $_fields = array(
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::DATA => array(
			'name'=>'data',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_Rate', self::$_fields);
		$this->data = new \TARS_Vector(new Config());
	}
}
