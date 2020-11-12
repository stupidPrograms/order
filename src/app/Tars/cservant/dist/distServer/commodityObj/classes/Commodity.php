<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class Commodity extends \TARS_Struct {
	const COMMODITY_ID = 0;
	const COVER = 1;
	const TITLE = 2;
	const PRICE = 3;
	const STOKE = 4;
	const TOTAL = 5;
	const STATUS = 6;
	const RATE = 7;
	const PENDING_STATUS = 8;


	public $commodity_id; 
	public $cover; 
	public $title; 
	public $price; 
	public $stoke; 
	public $total; 
	public $status; 
	public $rate; 
	public $pending_status; 


	protected static $_fields = array(
		self::COMMODITY_ID => array(
			'name'=>'commodity_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::COVER => array(
			'name'=>'cover',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TITLE => array(
			'name'=>'title',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STOKE => array(
			'name'=>'stoke',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TOTAL => array(
			'name'=>'total',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::RATE => array(
			'name'=>'rate',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::PENDING_STATUS => array(
			'name'=>'pending_status',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_Commodity', self::$_fields);
		$this->rate = new \TARS_Vector(new Config());
	}
}
