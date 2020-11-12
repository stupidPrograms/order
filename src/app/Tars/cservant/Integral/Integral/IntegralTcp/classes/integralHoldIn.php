<?php

namespace App\Tars\cservant\Integral\Integral\IntegralTcp\classes;

class integralHoldIn extends \TARS_Struct {
	const INTEGRAL_TASK_ID = 0;
	const UUID = 1;
	const MERCHANT_ID = 2;
	const SHOP_ID = 3;
	const REDUCE_INTEGRAL = 4;
	const USER_PHONE = 5;
	const STATUS = 6;
	const TITLE = 7;


	public $integral_task_id; 
	public $uuid; 
	public $merchant_id; 
	public $shop_id; 
	public $reduce_integral; 
	public $user_phone; 
	public $status; 
	public $title; 


	protected static $_fields = array(
		self::INTEGRAL_TASK_ID => array(
			'name'=>'integral_task_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MERCHANT_ID => array(
			'name'=>'merchant_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::REDUCE_INTEGRAL => array(
			'name'=>'reduce_integral',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::USER_PHONE => array(
			'name'=>'user_phone',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TITLE => array(
			'name'=>'title',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Integral_Integral_IntegralTcp_integralHoldIn', self::$_fields);
	}
}
