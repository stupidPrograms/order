<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class QueryParam extends \TARS_Struct {
	const MOBILE = 0;
	const TYPE = 1;
	const STARTAT = 2;
	const ENDAT = 3;
	const STATUS = 4;
	const PAGE = 5;
	const PAGESIZE = 6;


	public $mobile; 
	public $type; 
	public $startAt; 
	public $endAt; 
	public $status; 
	public $page; 
	public $pageSize; 


	protected static $_fields = array(
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>false,
			'type'=>\TARS::INT64,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>false,
			'type'=>\TARS::INT32,
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
		self::STATUS => array(
			'name'=>'status',
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
		parent::__construct('dist_distServer_performanceObj_QueryParam', self::$_fields);
	}
}
