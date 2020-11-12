<?php

namespace App\Tars\servant\IntegralSystem\IntegralServer\IntegralObj\classes;

class OutOrderInfo extends \TARS_Struct {
	const ID = 0;
	const ORDERSN = 1;
	const RECIPIENT = 2;
	const ADDRESS = 3;
	const PHONE = 4;
	const PAID_AT = 5;
	const STATUS = 6;
	const AMOUNT = 7;
	const GIFT_POINTS = 8;
	const DEPOSIT = 9;
	const SHOP_ID = 10;
	const GOODS = 11;


	public $id; 
	public $ordersn; 
	public $recipient; 
	public $address; 
	public $phone; 
	public $paid_at; 
	public $status; 
	public $amount; 
	public $gift_points; 
	public $deposit; 
	public $shop_id; 
	public $goods; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ORDERSN => array(
			'name'=>'ordersn',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::RECIPIENT => array(
			'name'=>'recipient',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ADDRESS => array(
			'name'=>'address',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PHONE => array(
			'name'=>'phone',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PAID_AT => array(
			'name'=>'paid_at',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::AMOUNT => array(
			'name'=>'amount',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::GIFT_POINTS => array(
			'name'=>'gift_points',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::DEPOSIT => array(
			'name'=>'deposit',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::GOODS => array(
			'name'=>'goods',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('IntegralSystem_IntegralServer_IntegralObj_OutOrderInfo', self::$_fields);
		$this->goods = new \TARS_Vector(new OrderGoods());
	}
}
