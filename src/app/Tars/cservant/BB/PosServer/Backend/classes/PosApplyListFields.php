<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class PosApplyListFields extends \TARS_Struct {
	const ID = 0;
	const SHOP_NAME = 1;
	const CONTACT = 2;
	const MOBILE = 3;
	const CREATED_AT = 4;


	public $id; 
	public $shop_name; 
	public $contact; 
	public $mobile; 
	public $created_at; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SHOP_NAME => array(
			'name'=>'shop_name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CONTACT => array(
			'name'=>'contact',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CREATED_AT => array(
			'name'=>'created_at',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_Backend_PosApplyListFields', self::$_fields);
	}
}
