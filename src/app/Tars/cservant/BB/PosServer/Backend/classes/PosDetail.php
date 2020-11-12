<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class PosDetail extends \TARS_Struct {
	const TYPE = 0;
	const CODE = 1;
	const CREATED_AT = 2;
	const STATUS = 3;


	public $type; 
	public $code; 
	public $created_at; 
	public $status; 


	protected static $_fields = array(
		self::TYPE => array(
			'name'=>'type',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CREATED_AT => array(
			'name'=>'created_at',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_Backend_PosDetail', self::$_fields);
	}
}
