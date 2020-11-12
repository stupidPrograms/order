<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class PosListQuery extends \TARS_Struct {
	const CODE = 0;


	public $code; 


	protected static $_fields = array(
		self::CODE => array(
			'name'=>'code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_PosListQuery', self::$_fields);
	}
}
