<?php

namespace App\Tars\cservant\dist\distServer\configObj\classes;

class PendingParam extends \TARS_Struct {
	const TOP_RATE = 0;
	const TOP_NEXT_RATE = 1;
	const SECOND_RATE = 2;
	const SECOND_NEXT_RATE = 3;


	public $top_rate; 
	public $top_next_rate; 
	public $second_rate; 
	public $second_next_rate; 


	protected static $_fields = array(
		self::TOP_RATE => array(
			'name'=>'top_rate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::TOP_NEXT_RATE => array(
			'name'=>'top_next_rate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SECOND_RATE => array(
			'name'=>'second_rate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::SECOND_NEXT_RATE => array(
			'name'=>'second_next_rate',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_configObj_PendingParam', self::$_fields);
	}
}
