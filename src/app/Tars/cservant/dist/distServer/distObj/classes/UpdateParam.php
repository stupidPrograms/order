<?php

namespace App\Tars\cservant\dist\distServer\distObj\classes;

class UpdateParam extends \TARS_Struct {
	const USERID = 1;
	const LEVEL = 2;


	public $userId; 
	public $level; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::LEVEL => array(
			'name'=>'level',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_distObj_UpdateParam', self::$_fields);
	}
}
