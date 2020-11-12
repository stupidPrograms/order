<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class inputBusiness extends \TARS_Struct {
	const SHOPNAME = 0;
	const PAGESIZE = 1;
	const PAGE = 2;


	public $shopName; 
	public $pageSize; 
	public $page; 


	protected static $_fields = array(
		self::SHOPNAME => array(
			'name'=>'shopName',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PAGESIZE => array(
			'name'=>'pageSize',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::PAGE => array(
			'name'=>'page',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_personalObj_inputBusiness', self::$_fields);
	}
}
