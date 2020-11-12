<?php

namespace App\Tars\cservant\BB\UserService\User\classes;

class UserData extends \TARS_Struct {
	const MOBILE = 0;
	const USER_TYPE = 1;


	public $mobile; 
	public $user_type; 


	protected static $_fields = array(
		self::MOBILE => array(
			'name'=>'mobile',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::USER_TYPE => array(
			'name'=>'user_type',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('BB_UserService_User_UserData', self::$_fields);
	}
}
