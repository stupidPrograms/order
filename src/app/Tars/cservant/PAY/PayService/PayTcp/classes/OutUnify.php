<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class OutUnify extends \TARS_Struct {
	const ORDERSN = 0;


	public $ordersn; 


	protected static $_fields = array(
		self::ORDERSN => array(
			'name'=>'ordersn',
			'required'=>false,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_OutUnify', self::$_fields);
	}
}
