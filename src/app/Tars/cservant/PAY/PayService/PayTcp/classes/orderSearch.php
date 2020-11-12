<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp\classes;

class orderSearch extends \TARS_Struct {
	const FIELD = 0;
	const CONDITION = 1;
	const VALUE = 2;


	public $field; 
	public $condition; 
	public $value; 


	protected static $_fields = array(
		self::FIELD => array(
			'name'=>'field',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::CONDITION => array(
			'name'=>'condition',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
		self::VALUE => array(
			'name'=>'value',
			'required'=>true,
			'type'=>\TARS::STRING,
			),
	);

	public function __construct() {
		parent::__construct('PAY_PayService_PayTcp_orderSearch', self::$_fields);
	}
}
