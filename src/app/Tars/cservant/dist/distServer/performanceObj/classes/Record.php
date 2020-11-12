<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class Record extends \TARS_Struct {
	const MOBILE = 0;
	const NICKNAME = 1;
	const CREATEDAT = 2;
	const TYPE = 3;
	const POINT = 4;
	const STATUS = 5;
	const TRAN_ID = 6;
	const ID = 7;


	public $mobile; 
	public $nickname; 
	public $createdAt; 
	public $type; 
	public $point; 
	public $status; 
	public $tran_id; 
	public $id; 


	protected static $_fields = array(
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>true,
			'type'=>\TARS::INT64,
			),
		self::NICKNAME => array(
			'name'=>'nickname',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CREATEDAT => array(
			'name'=>'createdAt',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::POINT => array(
			'name'=>'point',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TRAN_ID => array(
			'name'=>'tran_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_Record', self::$_fields);
	}
}
