<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class inWxPublicApply extends \TARS_Struct {
	const MECHANTNO = 0;
	const SUBSCRIBEAPPIDS = 1;
	const APPIDS = 2;
	const AUTHPAYDIRS = 3;


	public $mechantNo; 
	public $subscribeAppIds; 
	public $appIds; 
	public $authPayDirs; 


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
		self::APPIDS => array(
			'name'=>'appIds',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
		self::AUTHPAYDIRS => array(
			'name'=>'authPayDirs',
			'required'=>true,
			'type'=>\TARS::VECTOR,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_inWxPublicApply', self::$_fields);
		$this->subscribeAppIds = new \TARS_Vector(\TARS::STRING);
		$this->appIds = new \TARS_Vector(\TARS::STRING);
		$this->authPayDirs = new \TARS_Vector(\TARS::STRING);
	}
}
