<?php

namespace App\Tars\cservant\BB\UserService\Auth\classes;

class RoleForUser extends \TARS_Struct {
	const ROLE = 0;
	const UUID = 1;
	const ENVDOMAINID = 2;
	const TAG = 3;


	public $role; 
	public $uuid; 
	public $envDomainId; 
	public $tag; 


	protected static $_fields = array(
		self::ROLE => array(
			'name'=>'role',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
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
		parent::__construct('BB_UserService_Auth_RoleForUser', self::$_fields);
	}
}
