<?php

namespace App\Tars\servant\Shop\ShopTcp\ShopObj\classes;

class outMerchantInfo extends \TARS_Struct {
	const ID = 0;
	const STORE_ID = 1;
	const UID = 2;
	const COMPANY = 3;
	const ADDRESS = 4;
	const PHONE = 5;
	const EMAIL = 6;
	const LICENSE_NUM = 7;
	const LICENSE_IMG = 8;
	const PROVINCE_ID = 9;
	const CITY_ID = 10;
	const DISTRICT = 11;
	const INDUSTRY_CODE = 12;
	const BUSINESS_CATEGORY = 13;
	const LEGAL = 14;
	const LEGAL_IDCARD = 15;
	const IDCARD_START = 16;
	const IDCARD_END = 17;
	const IDCARD_FRONT = 18;
	const IDCARD_OPPOSITE = 19;
	const BANK_CODE = 20;
	const STATUS = 21;
	const BANKNAME = 22;
	const BANKCITY = 23;
	const BANKPROVINCE = 24;
	const AREA_ID = 25;
	const BANK_SUB_NAME = 26;
	const ACCOUNT_NAME = 27;
	const ACCOUNT_NO = 28;
	const MCC_CODE = 29;
	const REGISTERID = 30;
	const MERCHANT_NUMBER = 31;


	public $id; 
	public $store_id; 
	public $uid; 
	public $company; 
	public $address; 
	public $phone; 
	public $email; 
	public $license_num; 
	public $license_img; 
	public $province_id; 
	public $city_id; 
	public $district; 
	public $industry_code; 
	public $business_category; 
	public $legal; 
	public $legal_idCard; 
	public $idCard_start; 
	public $idCard_end; 
	public $idCard_front; 
	public $idCard_opposite; 
	public $bank_code; 
	public $status; 
	public $bankname; 
	public $bankcity; 
	public $bankprovince; 
	public $area_id; 
	public $bank_sub_name; 
	public $account_name; 
	public $account_no; 
	public $MCC_code; 
	public $registerId; 
	public $merchant_number; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::STORE_ID => array(
			'name'=>'store_id',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
		self::UID => array(
			'name'=>'uid',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::COMPANY => array(
			'name'=>'company',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::ADDRESS => array(
			'name'=>'address',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PHONE => array(
			'name'=>'phone',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::EMAIL => array(
			'name'=>'email',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LICENSE_NUM => array(
			'name'=>'license_num',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LICENSE_IMG => array(
			'name'=>'license_img',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::PROVINCE_ID => array(
			'name'=>'province_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::CITY_ID => array(
			'name'=>'city_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::DISTRICT => array(
			'name'=>'district',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::INDUSTRY_CODE => array(
			'name'=>'industry_code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BUSINESS_CATEGORY => array(
			'name'=>'business_category',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LEGAL => array(
			'name'=>'legal',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LEGAL_IDCARD => array(
			'name'=>'legal_idCard',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::IDCARD_START => array(
			'name'=>'idCard_start',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::IDCARD_END => array(
			'name'=>'idCard_end',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::IDCARD_FRONT => array(
			'name'=>'idCard_front',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::IDCARD_OPPOSITE => array(
			'name'=>'idCard_opposite',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BANK_CODE => array(
			'name'=>'bank_code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::STATUS => array(
			'name'=>'status',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BANKNAME => array(
			'name'=>'bankname',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BANKCITY => array(
			'name'=>'bankcity',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BANKPROVINCE => array(
			'name'=>'bankprovince',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::AREA_ID => array(
			'name'=>'area_id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::BANK_SUB_NAME => array(
			'name'=>'bank_sub_name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::ACCOUNT_NAME => array(
			'name'=>'account_name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::ACCOUNT_NO => array(
			'name'=>'account_no',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MCC_CODE => array(
			'name'=>'MCC_code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::REGISTERID => array(
			'name'=>'registerId',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::MERCHANT_NUMBER => array(
			'name'=>'merchant_number',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('Shop_ShopTcp_ShopObj_outMerchantInfo', self::$_fields);
	}
}
