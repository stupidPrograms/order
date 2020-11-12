<?php

namespace App\Tars\cservant\BB\UserService\Auth\classes;

class TokenPackage extends \TARS_Struct {
	const JWTTOKEN = 0;
	const EXPIREDAT = 1;
	const REFRESHAFTER = 2;
	const USERISFORMAL = 3;


	public $jwtToken; 
	public $expiredAt; 
	public $refreshAfter; 
	public $userIsFormal; 


	protected static $_fields = array(
		self::JWTTOKEN => array(
			'name'=>'jwtToken',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::EXPIREDAT => array(
			'name'=>'expiredAt',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::REFRESHAFTER => array(
			'name'=>'refreshAfter',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::USERISFORMAL => array(
			'name'=>'userIsFormal',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('BB_UserService_Auth_TokenPackage', self::$_fields);
	}
}
