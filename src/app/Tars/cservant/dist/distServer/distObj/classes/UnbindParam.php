<?php

namespace App\Tars\cservant\dist\distServer\distObj\classes;

class UnbindParam extends \TARS_Struct {
	const USERID = 1;


	public $userId; 


	protected static $_fields = array(
		self::USERID => array(
			'name'=>'userId',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('dist_distServer_distObj_UnbindParam', self::$_fields);
	}
}
