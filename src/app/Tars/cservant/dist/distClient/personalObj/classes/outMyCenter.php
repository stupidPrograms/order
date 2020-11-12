<?php

namespace App\Tars\cservant\dist\distClient\personalObj\classes;

class outMyCenter extends \TARS_Struct {
	const NICKNAME = 0;
	const HEADIMGURL = 1;


	public $nickname; 
	public $headImgUrl; 


	protected static $_fields = array(
		self::NICKNAME => array(
			'name'=>'nickname',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
		self::HEADIMGURL => array(
			'name'=>'headImgUrl',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distClient_personalObj_outMyCenter', self::$_fields);
	}
}
