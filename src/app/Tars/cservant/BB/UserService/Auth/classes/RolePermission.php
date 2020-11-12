<?php

namespace App\Tars\cservant\BB\UserService\Auth\classes;

class RolePermission extends \TARS_Struct {
	const ROLE = 0;
	const PATH = 1;
	const METHOD = 2;
	const DENY = 3;


	public $role; 
	public $path; 
	public $method; 
	public $deny; 


	protected static $_fields = array(
		self::ROLE => array(
			'name'=>'role',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PATH => array(
			'name'=>'path',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::METHOD => array(
			'name'=>'method',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DENY => array(
			'name'=>'deny',
			'required'=>false,
			'type'=>\TARS::BOOL,
			),
	);

	public function __construct() {
		parent::__construct('BB_UserService_Auth_RolePermission', self::$_fields);
	}
}
