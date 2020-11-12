<?php

namespace App\Tars\cservant\BB\PosServer\Backend\classes;

class CommonInParam extends \TARS_Struct {
	const PAGE = 0;
	const LIMIT = 1;


	public $page=1; 
	public $limit=10; 


	protected static $_fields = array(
		self::PAGE => array(
			'name'=>'page',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::LIMIT => array(
			'name'=>'limit',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('BB_PosServer_Backend_CommonInParam', self::$_fields);
	}
}
