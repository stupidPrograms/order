<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class PosApplyList extends \TARS_Struct {
	const PAGE = 0;
	const TOTAL = 1;
	const LIST = 2;


	public $page; 
	public $total; 
	public $list; 


	protected static $_fields = array(
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
		self::LIST => array(
			'name'=>'list',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_Backend_PosApplyList', self::$_fields);
		$this->list = new \TARS_Vector(new PosApplyListFields());
	}
}
