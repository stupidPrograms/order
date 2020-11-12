<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos\classes;

class CommonInParam extends \TARS_Struct {
	const SHOP_ID = 0;


	public $shop_id; 


	protected static $_fields = array(
		self::SHOP_ID => array(
			'name'=>'shop_id',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_ShopPos_CommonInParam', self::$_fields);
	}
}
