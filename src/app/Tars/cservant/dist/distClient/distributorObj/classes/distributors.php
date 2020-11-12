<?php

namespace App\Tars\cservant\dist\distClient\distributorObj\classes;

class distributors extends \TARS_Struct {
	const USERID = 0;
	const INVITERID = 1;
	const BUSINESSID = 2;
	const DOMAINID = 3;
	const CODE = 4;


	public $userId; 
	public $InviterId; 
	public $businessId; 
	public $domainId; 
	public $code; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::INVITERID => array(
			'name'=>'InviterId',
			'required'=>false,
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
		self::CODE => array(
			'name'=>'code',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_distributorObj_distributors', self::$_fields);
	}
}
