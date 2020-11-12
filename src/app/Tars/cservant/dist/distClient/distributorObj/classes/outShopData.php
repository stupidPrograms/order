<?php

namespace App\Tars\cservant\dist\distClient\distributorObj\classes;

class outShopData extends \TARS_Struct {
	const ID = 0;
	const LOGO = 1;
	const NAME = 2;


	public $Id; 
	public $logo; 
	public $name; 


	protected static $_fields = array(
		self::ID => array(
			'name'=>'Id',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::LOGO => array(
			'name'=>'logo',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::NAME => array(
			'name'=>'name',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_distributorObj_outShopData', self::$_fields);
	}
}
