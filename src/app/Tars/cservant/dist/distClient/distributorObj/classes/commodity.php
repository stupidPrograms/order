<?php

namespace App\Tars\cservant\dist\distClient\distributorObj\classes;

class commodity extends \TARS_Struct {
	const USERID = 0;
	const BUSINESSID = 1;
	const DOMAINID = 2;
	const SEARCH = 3;
	const DISTCOUNT = 4;
	const PRICE = 5;
	const PAGE = 6;
	const PAGESIZE = 7;


	public $userId; 
	public $businessId; 
	public $domainId; 
	public $search; 
	public $distCount; 
	public $price; 
	public $page; 
	public $pageSize; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SEARCH => array(
			'name'=>'search',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DISTCOUNT => array(
			'name'=>'distCount',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
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
	);

	public function __construct() {
		parent::__construct('dist_distClient_distributorObj_commodity', self::$_fields);
	}
}
