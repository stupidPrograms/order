<?php

namespace App\Tars\cservant\dist\distServer\distObj\classes;

class PendingParam extends \TARS_Struct {
	const USERID = 1;
	const STATUS = 2;


	public $userId; 
	public $status; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_distObj_PendingParam', self::$_fields);
	}
}
