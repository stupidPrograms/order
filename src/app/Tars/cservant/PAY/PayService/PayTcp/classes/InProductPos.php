<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InProductPos extends \TARS_Struct {
	const MECHANTNO = 0;
	const QUICKPASSFEES = 1;
	const FEERATE = 2;
	const CREFEERATE = 3;
	const UPLIMIT = 4;


	public $mechantNo; 
	public $quickPassFees; 
	public $feeRate; 
	public $creFeeRate; 
	public $upLimit; 


	protected static $_fields = array(
		self::MECHANTNO => array(
			'name'=>'mechantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::QUICKPASSFEES => array(
			'name'=>'quickPassFees',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::FEERATE => array(
			'name'=>'feeRate',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::CREFEERATE => array(
			'name'=>'creFeeRate',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
		self::UPLIMIT => array(
			'name'=>'upLimit',
			'required'=>true,
			'type'=>\TARS::FLOAT,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InProductPos', self::$_fields);
		$this->quickPassFees = new \TARS_Vector(new quickPassFeesInfo());
	}
}
