<?php

namespace App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes;

class PageParam extends \TARS_Struct {
	const PAGE = 0;
	const PAGESIZE = 1;
	const IDARRAY = 2;
	const SEARCH = 3;
	const SHOP_ID = 4;


	public $page; 
	public $pageSize; 
	public $idArray; 
	public $search; 
	public $shop_id; 


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
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('ProductTcp_ProductService_ProductObj_PageParam', self::$_fields);
	}
}
