<?php

namespace App\Tars\cservant\BB\Shop\ShopTcp\classes;

class ShopInfo extends \TARS_Struct {
	const ID = 0;
	const THUMB = 1;
	const NAME = 2;
	const TYPE = 3;
	const MOBILE = 4;
	const WECHAT = 5;
	const QQ = 6;
	const UID = 7;
	const PID = 8;
	const SURNAME = 9;
	const ISTRIAL = 10;
	const INDUSTRY_NAME = 11;
	const SHOPTYPE = 12;
	const STATUS = 13;
	const SERVICE = 14;
	const VERSION_TYPE = 15;


	public $id; 
	public $thumb; 
	public $name; 
	public $type; 
	public $mobile; 
	public $wechat; 
	public $qq; 
	public $uid; 
	public $pid; 
	public $surname; 
	public $istrial; 
	public $industry_name; 
	public $shoptype; 
	public $status; 
	public $service; 
	public $version_type; 


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
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::WECHAT => array(
			'name'=>'wechat',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::QQ => array(
			'name'=>'qq',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::UID => array(
			'name'=>'uid',
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
		self::STATUS => array(
			'name'=>'status',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::SERVICE => array(
			'name'=>'service',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::VERSION_TYPE => array(
			'name'=>'version_type',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_Shop_ShopTcp_ShopInfo', self::$_fields);
	}
}
