<?php

namespace App\Tars\cservant\BB\UserService\User\classes;

class WechatUser extends \TARS_Struct {
	const ID = 0;
	const OPENID = 1;
	const UUID = 2;
	const NICKNAME = 3;
	const SEX = 4;
	const ENVDOMAINID = 5;
	const HEADIMGURL = 6;


	public $id; 
	public $openid; 
	public $uuid; 
	public $nickname; 
	public $sex; 
	public $envDomainId=1; 
	public $headimgurl; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'id',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::OPENID => array(
			'name'=>'openid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::NICKNAME => array(
			'name'=>'nickname',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SEX => array(
			'name'=>'sex',
			'required'=>true,
			'type'=>\TARS::INT32,
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
	);

	public function __construct() {
		parent::__construct('BB_UserService_User_WechatUser', self::$_fields);
	}
}
