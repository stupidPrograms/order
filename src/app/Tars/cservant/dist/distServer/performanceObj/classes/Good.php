<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class Good extends \TARS_Struct {
	const DISTNAME = 0;
	const DISTMOBILE = 1;
	const DISTLEVEL = 2;
	const CUSTERNAME = 3;
	const DISTTYPE = 4;
	const STATUS = 5;
	const COVER = 6;
	const TITLE = 7;
	const PRICE = 8;
	const CURRENCY = 9;
	const CREATEDAT = 10;
	const PERTYPE = 11;
	const PERSTATUS = 12;
	const PERPOINT = 13;
	const CUSTERMOBILE = 14;


	public $distName; 
	public $distMobile; 
	public $distLevel; 
	public $custerName; 
	public $distType; 
	public $status; 
	public $cover; 
	public $title; 
	public $price; 
	public $currency; 
	public $createdAt; 
	public $perType; 
	public $perStatus; 
	public $perPoint; 
	public $custerMobile; 


	protected static $_fields = array(
		self::DISTNAME => array(
			'name'=>'distName',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DISTMOBILE => array(
			'name'=>'distMobile',
			'required'=>true,
			'type'=>\TARS::INT64,
			),
		self::DISTLEVEL => array(
			'name'=>'distLevel',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CUSTERNAME => array(
			'name'=>'custerName',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DISTTYPE => array(
			'name'=>'distType',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::STATUS => array(
			'name'=>'status',
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
		self::CURRENCY => array(
			'name'=>'currency',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CREATEDAT => array(
			'name'=>'createdAt',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PERTYPE => array(
			'name'=>'perType',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PERSTATUS => array(
			'name'=>'perStatus',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PERPOINT => array(
			'name'=>'perPoint',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CUSTERMOBILE => array(
			'name'=>'custerMobile',
			'required'=>true,
			'type'=>\TARS::INT64,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_Good', self::$_fields);
	}
}
