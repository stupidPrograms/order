<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class inputRelieve extends \TARS_Struct {
	const USERID = 0;
	const BUSINESSID = 1;
	const DOMAINID = 2;


	public $userId; 
	public $businessId; 
	public $domainId; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::BUSINESSID => array(
			'name'=>'businessId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::DOMAINID => array(
			'name'=>'domainId',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_personalObj_inputRelieve', self::$_fields);
	}
}
