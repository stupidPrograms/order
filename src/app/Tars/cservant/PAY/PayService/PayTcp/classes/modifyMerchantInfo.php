<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class modifyMerchantInfo extends \TARS_Struct {
	const MERCHANTNO = 0;
	const LEGALPERSONID = 1;
	const LEGALPERSON = 2;
	const BUSINESSLICENSE = 3;
	const SIGNNAME = 4;
	const IDCARDSTARTDATE = 5;
	const IDCARDENDDATE = 6;
	const BUSLICESTARTDATE = 7;
	const BUSLICEENDDATE = 8;
	const REGIONCODE = 9;
	const ADDRESS = 10;
	const MCC = 11;
	const SHOWNAME = 12;
	const SERVICEPHONE = 13;
	const LINKPHONE = 14;
	const LINKMAN = 15;
	const MERCHANTCATEGORY = 16;
	const MICROBIZTYPE = 17;
	const CERTTYPE = 18;
	const LINKMANID = 19;


	public $merchantNo; 
	public $legalPersonID; 
	public $legalPerson; 
	public $businessLicense; 
	public $signName; 
	public $idCardStartDate; 
	public $idCardEndDate; 
	public $busLiceStartDate; 
	public $busLiceEndDate; 
	public $regionCode; 
	public $address; 
	public $mcc; 
	public $showName; 
	public $servicePhone; 
	public $linkPhone; 
	public $linkman; 
	public $merchantCategory; 
	public $microBizType; 
	public $certType; 
	public $linkManId; 


	protected static $_fields = array(
		self::MERCHANTNO => array(
			'name'=>'merchantNo',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LEGALPERSONID => array(
			'name'=>'legalPersonID',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LEGALPERSON => array(
			'name'=>'legalPerson',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BUSINESSLICENSE => array(
			'name'=>'businessLicense',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SIGNNAME => array(
			'name'=>'signName',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::IDCARDSTARTDATE => array(
			'name'=>'idCardStartDate',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::IDCARDENDDATE => array(
			'name'=>'idCardEndDate',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BUSLICESTARTDATE => array(
			'name'=>'busLiceStartDate',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BUSLICEENDDATE => array(
			'name'=>'busLiceEndDate',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::REGIONCODE => array(
			'name'=>'regionCode',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::ADDRESS => array(
			'name'=>'address',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MCC => array(
			'name'=>'mcc',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SHOWNAME => array(
			'name'=>'showName',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::SERVICEPHONE => array(
			'name'=>'servicePhone',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LINKPHONE => array(
			'name'=>'linkPhone',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LINKMAN => array(
			'name'=>'linkman',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MERCHANTCATEGORY => array(
			'name'=>'merchantCategory',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MICROBIZTYPE => array(
			'name'=>'microBizType',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CERTTYPE => array(
			'name'=>'certType',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LINKMANID => array(
			'name'=>'linkManId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_modifyMerchantInfo', self::$_fields);
	}
}
