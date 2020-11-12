<?php

namespace App\Tars\cservant\Shop\ShopTcp\ShopObj\classes;

class PageParam extends \TARS_Struct {
	const PAGE = 0;
	const PAGESIZE = 1;
	const IDARRAY = 2;
	const SEARCH = 3;
	const STORE_ID = 4;


	public $page; 
	public $pageSize; 
	public $idArray; 
	public $search; 
	public $store_id; 


	protected static $_fields = array(
		self::PAGE => array(
			'name'=>'page',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::PAGESIZE => array(
			'name'=>'pageSize',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::IDARRAY => array(
			'name'=>'idArray',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SEARCH => array(
			'name'=>'search',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STORE_ID => array(
			'name'=>'store_id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('Shop_ShopTcp_ShopObj_PageParam', self::$_fields);
	}
}
