<?php

namespace App\Tars\cservant\dist\distServer\distObj\classes;

class SynchronizeParam extends \TARS_Struct {
	const USERID = 0;
	const MOBILE = 1;
	const NICKNAME = 2;


	public $userId; 
	public $mobile; 
	public $nickname; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
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
	);

	public function __construct() {
		parent::__construct('dist_distServer_distObj_SynchronizeParam', self::$_fields);
	}
}
