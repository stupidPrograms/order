<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class PosQuery extends \TARS_Struct {
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
		parent::__construct('BB_PosServer_Backend_PosQuery', self::$_fields);
	}
}
