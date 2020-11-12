<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class PendingCommodity extends \TARS_Struct {
	const COMMODITY_ID = 0;
	const COVER = 1;
	const TITLE = 2;
	const PRICE = 3;
	const CREATED_AT = 4;
	const RATE = 5;
	const SHOP_NAME = 6;
	const PENDING_STATUS = 7;


	public $commodity_id; 
	public $cover; 
	public $title; 
	public $price; 
	public $created_at; 
	public $rate; 
	public $shop_name; 
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
		self::CREATED_AT => array(
			'name'=>'created_at',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::RATE => array(
			'name'=>'rate',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::SHOP_NAME => array(
			'name'=>'shop_name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PENDING_STATUS => array(
			'name'=>'pending_status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_PendingCommodity', self::$_fields);
		$this->rate = new \TARS_Vector(new Config());
	}
}
