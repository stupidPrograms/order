<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class ClerksCheck extends \TARS_Struct {
	const POS_ID = 0;
	const UUID = 1;


	public $pos_id; 
	public $uuid; 


	protected static $_fields = array(
		self::POS_ID => array(
			'name'=>'pos_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_ClerksCheck', self::$_fields);
	}
}
