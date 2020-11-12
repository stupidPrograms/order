<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class ListInParam extends \TARS_Struct {
	const PAGE = 0;
	const LIMIT = 1;


	public $page=1; 
	public $limit=10; 


	protected static $_fields = array(
		self::PAGE => array(
			'name'=>'page',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::LIMIT => array(
			'name'=>'limit',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_ListInParam', self::$_fields);
	}
}
