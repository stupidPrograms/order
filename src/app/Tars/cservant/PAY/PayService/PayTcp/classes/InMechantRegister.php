<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class InMechantRegister extends \TARS_Struct {
	const SIGNNAME = 0;
	const REGIONCODE = 1;
	const ADDRESS = 2;
	const LINKNAME = 3;
	const PHONE = 4;
	const EMAIL = 5;
	const ACCOUNTIDCARD = 6;
	const IDCARDSTARTDATE = 7;
	const IDCARDENDDATE = 8;
	const BANKCODE = 9;
	const ACCOUNTNAME = 10;
	const ACCOUNTNO = 11;
	const INDUSTRYTYPECODE = 12;
	const BUSINESSLICENSE = 13;
	const MCC = 14;
	const MERCHANTCATEGORY = 15;
	const BUSLICESTARTDATE = 16;
	const BUSLICEENDDATE = 17;


	public $signName; 
	public $regionCode; 
	public $address; 
	public $linkName; 
	public $phone; 
	public $email; 
	public $accountIdCard; 
	public $idCardStartDate; 
	public $idCardEndDate; 
	public $bankCode; 
	public $accountName; 
	public $accountNo; 
	public $industryTypeCode; 
	public $businessLicense; 
	public $MCC; 
	public $merchantCategory; 
	public $busLiceStartDate; 
	public $busLiceEndDate; 


	protected static $_fields = array(
		self::SIGNNAME => array(
			'name'=>'signName',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::REGIONCODE => array(
			'name'=>'regionCode',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ADDRESS => array(
			'name'=>'address',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::LINKNAME => array(
			'name'=>'linkName',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PHONE => array(
			'name'=>'phone',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::EMAIL => array(
			'name'=>'email',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ACCOUNTIDCARD => array(
			'name'=>'accountIdCard',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::IDCARDSTARTDATE => array(
			'name'=>'idCardStartDate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::IDCARDENDDATE => array(
			'name'=>'idCardEndDate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BANKCODE => array(
			'name'=>'bankCode',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ACCOUNTNAME => array(
			'name'=>'accountName',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ACCOUNTNO => array(
			'name'=>'accountNo',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::INDUSTRYTYPECODE => array(
			'name'=>'industryTypeCode',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BUSINESSLICENSE => array(
			'name'=>'businessLicense',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MCC => array(
			'name'=>'MCC',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::MERCHANTCATEGORY => array(
			'name'=>'merchantCategory',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BUSLICESTARTDATE => array(
			'name'=>'busLiceStartDate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BUSLICEENDDATE => array(
			'name'=>'busLiceEndDate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_InMechantRegister', self::$_fields);
	}
}
