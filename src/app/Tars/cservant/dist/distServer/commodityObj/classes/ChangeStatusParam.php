<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class ChangeStatusParam extends \TARS_Struct {
	const COMMODITYID = 0;
	const STATUS = 1;


	public $commodityId; 
	public $status; 


	protected static $_fields = array(
		self::COMMODITYID => array(
			'name'=>'commodityId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_ChangeStatusParam', self::$_fields);
	}
}
