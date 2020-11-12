<?php

namespace App\Tars\servant\Shop\ShopTcp\ShopObj\classes;

class PageParamList extends \TARS_Struct {
	const PAGE = 0;
	const PAGESIZE = 1;
	const SEARCH = 2;
	const STORE_ID = 3;


	public $page; 
	public $pageSize; 
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
		parent::__construct('Shop_ShopTcp_ShopObj_PageParamList', self::$_fields);
	}
}
