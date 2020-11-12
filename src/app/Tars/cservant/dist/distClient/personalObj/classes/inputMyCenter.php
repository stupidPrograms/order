<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class inputMyCenter extends \TARS_Struct {
	const USERID = 0;
	const DOMAINID = 1;


	public $userId; 
	public $domainId; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
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
		parent::__construct('dist_distClient_personalObj_inputMyCenter', self::$_fields);
	}
}
