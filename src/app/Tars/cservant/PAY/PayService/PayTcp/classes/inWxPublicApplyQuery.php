<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class inWxPublicApplyQuery extends \TARS_Struct {
	const MECHANTNO = 0;
	const SUBSCRIBEAPPIDS = 1;


	public $mechantNo; 
	public $subscribeAppIds; 


	protected static $_fields = array(
		self::MECHANTNO => array(
			'name'=>'mechantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SUBSCRIBEAPPIDS => array(
			'name'=>'subscribeAppIds',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_inWxPublicApplyQuery', self::$_fields);
		$this->subscribeAppIds = new \TARS_Vector(\TARS::STRING);
	}
}
