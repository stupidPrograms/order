<?php

namespace App\Tars\cservant\BB\UserService\User\classes;

class UserInfo extends \TARS_Struct {
	const UUID = 0;
	const ACCOUNT = 1;
	const NICKNAME = 2;
	const MOBILE = 3;
	const CREATEDAT = 4;
	const ENVDOMAINID = 5;
	const HEADIMGURL = 6;
	const SEX = 7;
	const SIGNATURE = 8;


	public $uuid; 
	public $account; 
	public $nickname; 
	public $mobile; 
	public $createdAt; 
	public $envDomainId=1; 
	public $headimgurl; 
	public $sex; 
	public $signature; 


	protected static $_fields = array(
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ACCOUNT => array(
			'name'=>'account',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NICKNAME => array(
			'name'=>'nickname',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CREATEDAT => array(
			'name'=>'createdAt',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ENVDOMAINID => array(
			'name'=>'envDomainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::HEADIMGURL => array(
			'name'=>'headimgurl',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SEX => array(
			'name'=>'sex',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::SIGNATURE => array(
			'name'=>'signature',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_UserService_User_UserInfo', self::$_fields);
	}
}
