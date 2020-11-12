<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class PendingPage extends \TARS_Struct {
	const LIST = 0;
	const PAGE = 1;
	const TOTAL = 2;


	public $list; 
	public $page; 
	public $total; 


	protected static $_fields = array(
		self::LIST => array(
			'name'=>'list',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::PAGE => array(
			'name'=>'page',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TOTAL => array(
			'name'=>'total',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_PendingPage', self::$_fields);
		$this->list = new \TARS_Vector(new PendingCommodity());
	}
}
