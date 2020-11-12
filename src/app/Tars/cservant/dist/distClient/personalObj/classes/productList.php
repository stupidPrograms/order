<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class productList extends \TARS_Struct {
	const ID = 0;
	const NAME = 1;
	const THUMB = 2;
	const PRICE = 3;
	const INTEGRAL = 4;
	const FINISHEDAT = 5;
	const DISTRIBUTOR = 6;


	public $id; 
	public $name; 
	public $thumb; 
	public $price; 
	public $integral; 
	public $finishedAt; 
	public $distributor; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::NAME => array(
			'name'=>'name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::THUMB => array(
			'name'=>'thumb',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::INTEGRAL => array(
			'name'=>'integral',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::FINISHEDAT => array(
			'name'=>'finishedAt',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DISTRIBUTOR => array(
			'name'=>'distributor',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_personalObj_productList', self::$_fields);
	}
}
