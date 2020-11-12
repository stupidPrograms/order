<?php

namespace App\Tars\cservant\BB\OperationCenter\Operation\classes;

class PlatformQuery extends \TARS_Struct {
	const DOMAIN = 0;
	const ENVDOMAINID = 1;
	const PRIMARY = 2;
	const NAME = 3;
	const PAGINATION = 4;


	public $domain; 
	public $envDomainId; 
	public $primary; 
	public $name; 
	public $pagination; 


	protected static $_fields = array(
		self::DOMAIN => array(
			'name'=>'domain',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ENVDOMAINID => array(
			'name'=>'envDomainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PRIMARY => array(
			'name'=>'primary',
			'required'=>true,
			'type'=>\TARS::BOOL,
			),
		self::NAME => array(
			'name'=>'name',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PAGINATION => array(
			'name'=>'pagination',
			'required'=>false,
			'type'=>\TARS::STRUCT,
			),
	);

	public function __construct() {
		parent::__construct('BB_OperationCenter_Operation_PlatformQuery', self::$_fields);
		$this->pagination = new Pagination();
	}
}
