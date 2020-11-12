<?php

namespace App\Tars\cservant\dist\distServer\distObj\classes;

class QueryParam extends \TARS_Struct {
	const MOBILE = 1;
	const REFERRERMOBILE = 2;
	const STARTAT = 3;
	const ENDAT = 4;
	const PAGE = 5;
	const PAGESIZE = 6;


	public $mobile; 
	public $referrerMobile; 
	public $startAt; 
	public $endAt; 
	public $page; 
	public $pageSize; 


	protected static $_fields = array(
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::REFERRERMOBILE => array(
			'name'=>'referrerMobile',
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
		parent::__construct('dist_distServer_distObj_QueryParam', self::$_fields);
	}
}
