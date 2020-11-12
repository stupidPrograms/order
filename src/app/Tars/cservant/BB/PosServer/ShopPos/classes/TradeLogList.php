<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class TradeLogList extends \TARS_Struct {
	const ID = 0;
	const TIME = 1;
	const TYPE = 2;
	const PRICE = 3;
	const STATUS = 4;
	const ADDRESS = 5;


	public $id; 
	public $time; 
	public $type; 
	public $price; 
	public $status; 
	public $address; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TIME => array(
			'name'=>'time',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PRICE => array(
			'name'=>'price',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ADDRESS => array(
			'name'=>'address',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_TradeLogList', self::$_fields);
	}
}
