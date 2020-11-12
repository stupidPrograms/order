<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class Pos extends \TARS_Struct {
	const ID = 0;
	const TYPE = 1;
	const CODE = 2;


	public $id; 
	public $type; 
	public $code; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
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
	);

	public function __construct() {
		parent::__construct('BB_PosServer_Backend_Pos', self::$_fields);
	}
}
