<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class business extends \TARS_Struct {
	const BUSINESSID = 0;
	const DOMAINID = 1;
	const NAME = 2;
	const THUMB = 3;
	const TRANCOUNT = 4;
	const AMOUNTCOUNT = 5;
	const LEVEL = 6;


	public $businessId; 
	public $domainId; 
	public $name; 
	public $thumb; 
	public $tranCount; 
	public $amountCount; 
	public $level; 


	protected static $_fields = array(
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
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
		self::TRANCOUNT => array(
			'name'=>'tranCount',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::AMOUNTCOUNT => array(
			'name'=>'amountCount',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::LEVEL => array(
			'name'=>'level',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_personalObj_business', self::$_fields);
	}
}
