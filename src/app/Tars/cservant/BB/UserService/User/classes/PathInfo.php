<?php

namespace App\Tars\cservant\BB\UserService\User\classes;

class PathInfo extends \TARS_Struct {
	const UUID = 0;
	const ENVDOMAINID = 1;
	const PATH = 2;
	const METHOD = 3;


	public $uuid; 
	public $envDomainId="1"; 
	public $path; 
	public $method; 


	protected static $_fields = array(
		self::UUID => array(
			'name'=>'uuid',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ENVDOMAINID => array(
			'name'=>'envDomainId',
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
	);

	public function __construct() {
		parent::__construct('BB_UserService_User_PathInfo', self::$_fields);
	}
}
