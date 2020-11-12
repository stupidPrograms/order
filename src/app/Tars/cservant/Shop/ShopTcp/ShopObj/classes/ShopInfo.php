<?php

namespace App\Tars\cservant\Shop\ShopTcp\ShopObj\classes;

class ShopInfo extends \TARS_Struct {
	const ID = 0;
	const THUMB = 1;
	const NAME = 2;
	const TYPE = 3;
	const PHONE = 4;
	const UID = 5;
	const EXPIRETIME = 6;
	const PID = 7;
	const SURNAME = 8;
	const ISTRIAL = 9;
	const DOMAIN_ID = 10;
	const INDUSTRY_NAME = 11;
	const SHOPTYPE = 12;
	const MERCHANT_NUMBER = 13;
	const CODE = 14;
	const MESSAGE = 15;


	public $id; 
	public $thumb; 
	public $name; 
	public $type; 
	public $phone; 
	public $uid; 
	public $expiretime; 
	public $pid; 
	public $surname; 
	public $istrial; 
	public $domain_id; 
	public $industry_name; 
	public $shoptype; 
	public $merchant_number; 
	public $code; 
	public $message; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::THUMB => array(
			'name'=>'thumb',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::NAME => array(
			'name'=>'name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PHONE => array(
			'name'=>'phone',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::UID => array(
			'name'=>'uid',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::EXPIRETIME => array(
			'name'=>'expiretime',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PID => array(
			'name'=>'pid',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SURNAME => array(
			'name'=>'surname',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::ISTRIAL => array(
			'name'=>'istrial',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DOMAIN_ID => array(
			'name'=>'domain_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::INDUSTRY_NAME => array(
			'name'=>'industry_name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SHOPTYPE => array(
			'name'=>'shoptype',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MERCHANT_NUMBER => array(
			'name'=>'merchant_number',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::MESSAGE => array(
			'name'=>'message',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Shop_ShopTcp_ShopObj_ShopInfo', self::$_fields);
	}
}
