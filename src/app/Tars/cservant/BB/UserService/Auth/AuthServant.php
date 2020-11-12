<?php

namespace App\Tars\cservant\BB\UserService\Auth;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\BB\UserService\Auth\classes\RolePermission;
use App\Tars\cservant\BB\UserService\Auth\classes\RoleForUser;
use App\Tars\cservant\BB\UserService\Auth\classes\Access;
use App\Tars\cservant\BB\UserService\Auth\classes\AuthUser;
use App\Tars\cservant\BB\UserService\Auth\classes\Pagination;
class AuthServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "BB.UserService.Auth";

	public function __construct(CommunicatorConfig $config) {
		try {
			$config->setServantName($this->_servantName);
			$this->_communicator = new Communicator($config);
			$this->_iVersion = $config->getIVersion();
			$this->_iTimeout = empty($config->getAsyncInvokeTimeout())?2:$config->getAsyncInvokeTimeout();
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function addRolePermission(RolePermission $rp,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("rp",1,$rp,$this->_iVersion);
			$encodeBufs['rp'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function delRolePermission(RolePermission $rp,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("rp",1,$rp,$this->_iVersion);
			$encodeBufs['rp'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function delRole($role,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("role",1,$role,$this->_iVersion);
			$encodeBufs['role'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function addRoleForRole($childRole,$parentRole,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("childRole",1,$childRole,$this->_iVersion);
			$encodeBufs['childRole'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("parentRole",2,$parentRole,$this->_iVersion);
			$encodeBufs['parentRole'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function delRoleFromRole($childRole,$parentRole,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("childRole",1,$childRole,$this->_iVersion);
			$encodeBufs['childRole'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("parentRole",2,$parentRole,$this->_iVersion);
			$encodeBufs['parentRole'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function addRoleForUser(RoleForUser $rfu,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("rfu",1,$rfu,$this->_iVersion);
			$encodeBufs['rfu'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function delRoleForUser(RoleForUser $rfu,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("rfu",1,$rfu,$this->_iVersion);
			$encodeBufs['rfu'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function validateAccess(Access $ac,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("ac",1,$ac,$this->_iVersion);
			$encodeBufs['ac'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$errMsg = TUPAPIWrapper::getString("errMsg",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function searchRoles(AuthUser $user,&$roles,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("user",1,$user,$this->_iVersion);
			$encodeBufs['user'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$roles = TUPAPIWrapper::getVector("roles",2,new \TARS_Vector(\TARS::STRING),$sBuffer,$this->_iVersion);
			$errMsg = TUPAPIWrapper::getString("errMsg",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function searchUsers($role,$envDomainId,$tag,Pagination $pagination,&$uuids,Pagination &$oPagination,&$errMsg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("role",1,$role,$this->_iVersion);
			$encodeBufs['role'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("envDomainId",2,$envDomainId,$this->_iVersion);
			$encodeBufs['envDomainId'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("tag",3,$tag,$this->_iVersion);
			$encodeBufs['tag'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("pagination",4,$pagination,$this->_iVersion);
			$encodeBufs['pagination'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$uuids = TUPAPIWrapper::getVector("uuids",5,new \TARS_Vector(\TARS::STRING),$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("oPagination",6,$oPagination,$sBuffer,$this->_iVersion);
			$errMsg = TUPAPIWrapper::getString("errMsg",7,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

