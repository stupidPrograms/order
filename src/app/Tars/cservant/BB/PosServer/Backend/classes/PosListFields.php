<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class PosListFields extends \TARS_Struct {
	const ID = 0;
	const CODE = 1;
	const TYPE = 2;
	const CREATED_AT = 3;
	const STATUS = 4;


	public $id; 
	public $code; 
	public $type; 
	public $created_at; 
	public $status; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::CODE => array(
			'name'=>'code',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TYPE => array(
			'name'=>'type',
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
		parent::__construct('BB_PosServer_Backend_PosListFields', self::$_fields);
	}
}
