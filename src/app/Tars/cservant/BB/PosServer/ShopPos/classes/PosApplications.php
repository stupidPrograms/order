<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class PosApplications extends \TARS_Struct {
	const SHOP_ID = 0;
	const MOBILE = 1;
	const CONTACT = 2;
	const ADDRESS = 3;


	public $shop_id; 
	public $mobile; 
	public $contact; 
	public $address; 


	protected static $_fields = array(
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CONTACT => array(
			'name'=>'contact',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ADDRESS => array(
			'name'=>'address',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_PosApplications', self::$_fields);
	}
}
