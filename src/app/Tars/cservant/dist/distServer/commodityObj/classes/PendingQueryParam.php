<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class PendingQueryParam extends \TARS_Struct {
	const PAGE = 0;
	const PAGESIZE = 1;
	const COMMODITYNAME = 2;
	const SHOPNAME = 3;
	const STARTAT = 4;
	const ENDAT = 5;


	public $page; 
	public $pageSize; 
	public $commodityName; 
	public $shopName; 
	public $startAt; 
	public $endAt; 


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
		self::COMMODITYNAME => array(
			'name'=>'commodityName',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SHOPNAME => array(
			'name'=>'shopName',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STARTAT => array(
			'name'=>'startAt',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::ENDAT => array(
			'name'=>'endAt',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_PendingQueryParam', self::$_fields);
	}
}
