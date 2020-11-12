<?php

namespace App\Tars\cservant\BB\OperationCenter\Operation;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\BB\OperationCenter\Operation\classes\Platform;
use App\Tars\cservant\BB\OperationCenter\Operation\classes\PlatformQuery;
class OperationServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "BB.OperationCenter.Operation";

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

	public function getPlatformByDomain($domain,Platform &$pf,&$err) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("domain",1,$domain,$this->_iVersion);
			$encodeBufs['domain'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("pf",2,$pf,$sBuffer,$this->_iVersion);
			$err = TUPAPIWrapper::getString("err",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getPlatformListByQuery(PlatformQuery $query,&$list,&$err) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("query",1,$query,$this->_iVersion);
			$encodeBufs['query'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$list = TUPAPIWrapper::getVector("list",2,new \TARS_Vector(new Platform()),$sBuffer,$this->_iVersion);
			$err = TUPAPIWrapper::getString("err",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function addDomainToPlatform(Platform $pf,Platform &$newPf,&$err) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("pf",1,$pf,$this->_iVersion);
			$encodeBufs['pf'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("newPf",2,$newPf,$sBuffer,$this->_iVersion);
			$err = TUPAPIWrapper::getString("err",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function removeDomain($domain,&$err) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("domain",1,$domain,$this->_iVersion);
			$encodeBufs['domain'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$err = TUPAPIWrapper::getString("err",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function CheckAdminPermission($token,$path,$action,$params,&$err) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("token",1,$token,$this->_iVersion);
			$encodeBufs['token'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("path",2,$path,$this->_iVersion);
			$encodeBufs['path'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("action",3,$action,$this->_iVersion);
			$encodeBufs['action'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("params",4,$params,$this->_iVersion);
			$encodeBufs['params'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$err = TUPAPIWrapper::getString("err",5,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function GetAdminInfo($token,&$account,&$roles) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("token",1,$token,$this->_iVersion);
			$encodeBufs['token'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$account = TUPAPIWrapper::getString("account",2,$sBuffer,$this->_iVersion);
			$roles = TUPAPIWrapper::getVector("roles",3,new \TARS_Vector(\TARS::STRING),$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

