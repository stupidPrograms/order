<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class inputRecords extends \TARS_Struct {
	const USERID = 0;
	const DOMAINID = 1;
	const TODAY = 2;
	const YESTERDAY = 3;
	const SEVENDAYSAGO = 4;
	const THIRTYDAYSAGO = 5;
	const PAGE = 6;
	const PAGESIZE = 7;


	public $userId; 
	public $domainId; 
	public $today; 
	public $Yesterday; 
	public $SevenDaysAgo; 
	public $ThirtyDaysAgo; 
	public $page; 
	public $pageSize; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TODAY => array(
			'name'=>'today',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::YESTERDAY => array(
			'name'=>'Yesterday',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::SEVENDAYSAGO => array(
			'name'=>'SevenDaysAgo',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::THIRTYDAYSAGO => array(
			'name'=>'ThirtyDaysAgo',
			'required'=>false,
			'type'=>\TARS::INT32,
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
		parent::__construct('dist_distClient_personalObj_inputRecords', self::$_fields);
	}
}
