<?php

namespace App\Tars\cservant\dist\distClient\distributorObj\classes;

class productList extends \TARS_Struct {
	const ID = 0;
	const NAME = 1;
	const THUMB = 2;
	const RATE = 3;
	const PRICE = 4;
	const DISTCOUNT = 5;
	const DISTID = 6;
	const TYPE = 7;
	const DESCRIBE = 8;


	public $id; 
	public $name; 
	public $thumb; 
	public $rate; 
	public $price; 
	public $distCount; 
	public $distId; 
	public $type; 
	public $describe; 


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
		self::RATE => array(
			'name'=>'rate',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::DISTCOUNT => array(
			'name'=>'distCount',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::DISTID => array(
			'name'=>'distId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::DESCRIBE => array(
			'name'=>'describe',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_distributorObj_productList', self::$_fields);
	}
}
