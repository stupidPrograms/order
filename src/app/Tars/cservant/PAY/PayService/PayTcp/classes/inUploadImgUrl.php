<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class inUploadImgUrl extends \TARS_Struct {
	const MECHANTNO = 0;
	const FRONTURL = 1;
	const BACKURL = 2;
	const BUSINESSLICENSE = 3;
	const BANKCARD = 4;
	const PERMITFORBANKACCOUNT = 5;
	const CHECKOUTCOUNTER = 6;
	const INTERIORPHOTO = 7;
	const SIGNBOARD = 8;


	public $mechantNo; 
	public $frontUrl; 
	public $backUrl; 
	public $businessLicense; 
	public $bankCard; 
	public $permitForBankAccount; 
	public $checkoutCounter; 
	public $interiorPhoto; 
	public $signBoard; 


	protected static $_fields = array(
		self::MECHANTNO => array(
			'name'=>'mechantNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::FRONTURL => array(
			'name'=>'frontUrl',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BACKURL => array(
			'name'=>'backUrl',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BUSINESSLICENSE => array(
			'name'=>'businessLicense',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BANKCARD => array(
			'name'=>'bankCard',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PERMITFORBANKACCOUNT => array(
			'name'=>'permitForBankAccount',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CHECKOUTCOUNTER => array(
			'name'=>'checkoutCounter',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::INTERIORPHOTO => array(
			'name'=>'interiorPhoto',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SIGNBOARD => array(
			'name'=>'signBoard',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_inUploadImgUrl', self::$_fields);
	}
}
