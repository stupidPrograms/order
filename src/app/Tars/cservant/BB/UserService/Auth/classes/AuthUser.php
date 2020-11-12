<?php

namespace App\Tars\cservant\BB\UserService\Auth\classes;

class AuthUser extends \TARS_Struct {
	const UUID = 1;
	const ENVDOMAINID = 2;
	const TAG = 3;


	public $uuid; 
	public $envDomainId; 
	public $tag; 


	protected static $_fields = array(
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ENVDOMAINID => array(
			'name'=>'envDomainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::TAG => array(
			'name'=>'tag',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_UserService_Auth_AuthUser', self::$_fields);
	}
}
