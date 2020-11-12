<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class PosList extends \TARS_Struct {
	const TOTAL = 0;
	const PAGE = 1;
	const LIST = 2;


	public $total; 
	public $page; 
	public $list; 


	protected static $_fields = array(
		self::TOTAL => array(
			'name'=>'total',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PAGE => array(
			'name'=>'page',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::LIST => array(
			'name'=>'list',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_PosList', self::$_fields);
		$this->list = new \TARS_Vector(new PosListFields());
	}
}
