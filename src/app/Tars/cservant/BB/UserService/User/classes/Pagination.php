<?php

namespace App\Tars\cservant\BB\UserService\User\classes;

class Pagination extends \TARS_Struct {
	const PAGE = 0;
	const PERPAGE = 1;
	const COUNT = 2;


	public $page; 
	public $perPage; 
	public $count; 


	protected static $_fields = array(
		self::PAGE => array(
			'name'=>'page',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::PERPAGE => array(
			'name'=>'perPage',
			'required'=>true,
			'type'=>\TARS::INT32,
			),
		self::COUNT => array(
			'name'=>'count',
			'required'=>false,
			'type'=>\TARS::INT32,
			),
	);

	public function __construct() {
		parent::__construct('BB_UserService_User_Pagination', self::$_fields);
	}
}
