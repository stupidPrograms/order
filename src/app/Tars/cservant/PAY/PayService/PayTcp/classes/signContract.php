<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class signContract extends \TARS_Struct {
	const EMAIL = 0;
	const PHONE = 1;
	const LEGALPERSONID = 2;
	const LEGALPERSON = 3;
	const SIGNNAME = 4;
	const ADDRESS = 5;
	const CALLBACKURL = 6;


	public $email; 
	public $phone; 
	public $legalPersonID; 
	public $legalPerson; 
	public $signName; 
	public $address; 
	public $callBackUrl; 


	protected static $_fields = array(
		self::EMAIL => array(
			'name'=>'email',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::PHONE => array(
			'name'=>'phone',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::LEGALPERSONID => array(
			'name'=>'legalPersonID',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::LEGALPERSON => array(
			'name'=>'legalPerson',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SIGNNAME => array(
			'name'=>'signName',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ADDRESS => array(
			'name'=>'address',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CALLBACKURL => array(
			'name'=>'callBackUrl',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_signContract', self::$_fields);
	}
}
