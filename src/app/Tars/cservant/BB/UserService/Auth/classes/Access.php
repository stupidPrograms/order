<?php

namespace App\Tars\cservant\BB\UserService\Auth\classes;

class Access extends \TARS_Struct {
	const UUID = 0;
	const ENVDOMAINID = 1;
	const PATH = 2;
	const METHOD = 3;
	const TAG = 4;


	public $uuid; 
	public $envDomainId; 
	public $path; 
	public $method; 
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
		self::TAG => array(
			'name'=>'tag',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('BB_UserService_Auth_Access', self::$_fields);
	}
}
