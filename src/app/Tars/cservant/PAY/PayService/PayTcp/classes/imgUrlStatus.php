<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class imgUrlStatus extends \TARS_Struct {
	const STATUS = 0;
	const MSG = 1;


	public $status; 
	public $msg; 


	protected static $_fields = array(
		self::STATUS => array(
			'name'=>'status',
			'required'=>true,
			'type'=>\TARS::MAP,
			),
		self::MSG => array(
			'name'=>'msg',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_imgUrlStatus', self::$_fields);
		$this->status = new \TARS_Map(\TARS::STRING,\TARS::INT32);
	}
}
