<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class QueryParam extends \TARS_Struct {
	const PAGE = 0;
	const PAGESIZE = 1;
	const TITLE = 2;
	const SORT = 3;
	const STATUS = 4;


	public $page; 
	public $pageSize; 
	public $title; 
	public $sort; 
	public $status; 


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
		self::TITLE => array(
			'name'=>'title',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SORT => array(
			'name'=>'sort',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_QueryParam', self::$_fields);
	}
}
