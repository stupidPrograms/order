<?php

namespace App\Tars\cservant\dist\distServer\performanceObj\classes;

class DailyParam extends \TARS_Struct {
	const STARTAT = 0;
	const ENDAT = 1;


	public $startAt; 
	public $endAt; 


	protected static $_fields = array(
		self::STARTAT => array(
			'name'=>'startAt',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::ENDAT => array(
			'name'=>'endAt',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_performanceObj_DailyParam', self::$_fields);
	}
}
