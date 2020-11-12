<?php

namespace App\Tars\cservant\dist\distServer\distObj\classes;

class Distributor extends \TARS_Struct {
	const USERID = 0;
	const MOBILE = 1;
	const NICKNAME = 2;
	const LEVEL = 3;
	const CREATEDAT = 4;
	const REFERRERMOBILE = 5;
	const TOTAL = 6;
	const POINT = 7;


	public $userId; 
	public $mobile; 
	public $nickname; 
	public $level; 
	public $createdAt; 
	public $referrerMobile; 
	public $total; 
	public $point; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::NICKNAME => array(
			'name'=>'nickname',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LEVEL => array(
			'name'=>'level',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::CREATEDAT => array(
			'name'=>'createdAt',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::REFERRERMOBILE => array(
			'name'=>'referrerMobile',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::TOTAL => array(
			'name'=>'total',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::POINT => array(
			'name'=>'point',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_distObj_Distributor', self::$_fields);
	}
}
