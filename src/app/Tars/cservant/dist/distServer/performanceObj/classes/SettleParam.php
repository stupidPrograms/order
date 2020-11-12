<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class SettleParam extends \TARS_Struct {
	const TRAN_ID = 0;
	const ID = 1;


	public $tran_id; 
	public $id; 


	protected static $_fields = array(
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
		parent::__construct('dist_distServer_performanceObj_SettleParam', self::$_fields);
	}
}
