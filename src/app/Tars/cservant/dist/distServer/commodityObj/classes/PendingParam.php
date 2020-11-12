<?php

namespace App\Tars\cservant\dist\distServer\commodityObj\classes;

class PendingParam extends \TARS_Struct {
	const COMMODITY_ID = 0;
	const STATUS = 1;


	public $commodity_id; 
	public $status; 


	protected static $_fields = array(
		self::COMMODITY_ID => array(
			'name'=>'commodity_id',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_commodityObj_PendingParam', self::$_fields);
		$this->commodity_id = new \TARS_Vector(\TARS::INT32);
	}
}
