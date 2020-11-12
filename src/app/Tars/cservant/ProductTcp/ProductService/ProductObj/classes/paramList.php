<?php

namespace App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes;

class paramList extends \TARS_Struct {
	const PAGE = 0;
	const PAGESIZE = 1;
	const OUTGETARRAYID = 2;
	const IDARRAY = 3;
	const SEARCH = 4;


	public $page; 
	public $pageSize; 
	public $outGetArrayId; 
	public $idArray; 
	public $search; 


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
		self::OUTGETARRAYID => array(
			'name'=>'outGetArrayId',
			'required'=>false,
			'type'=>\TARS::VECTOR,
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
	);

	public function __construct() {
		parent::__construct('ProductTcp_ProductService_ProductObj_paramList', self::$_fields);
		$this->outGetArrayId = new \TARS_Vector(\TARS::INT32);
	}
}
