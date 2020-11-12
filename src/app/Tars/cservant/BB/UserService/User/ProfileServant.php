<?php

namespace App\Tars\cservant\BB\UserService\User;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\BB\UserService\User\classes\UserInfo;
class ProfileServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "BB.UserService.User";

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

	public function bindNewMobile($uuid,$envDomainId,$newMobile,$md5Password,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("envDomainId",2,$envDomainId,$this->_iVersion);
			$encodeBufs['envDomainId'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("newMobile",3,$newMobile,$this->_iVersion);
			$encodeBufs['newMobile'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("md5Password",4,$md5Password,$this->_iVersion);
			$encodeBufs['md5Password'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$error = TUPAPIWrapper::getString("error",5,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function bindNewAccount($uuid,$envDomainId,$newAccount,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("envDomainId",2,$envDomainId,$this->_iVersion);
			$encodeBufs['envDomainId'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("newAccount",3,$newAccount,$this->_iVersion);
			$encodeBufs['newAccount'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function resetPassword($uuid,$envDomainId,$md5Password,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("envDomainId",2,$envDomainId,$this->_iVersion);
			$encodeBufs['envDomainId'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("md5Password",3,$md5Password,$this->_iVersion);
			$encodeBufs['md5Password'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function resetPasswordByMobile($mobile,$envDomainId,$md5Password,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("mobile",1,$mobile,$this->_iVersion);
			$encodeBufs['mobile'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("envDomainId",2,$envDomainId,$this->_iVersion);
			$encodeBufs['envDomainId'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("md5Password",3,$md5Password,$this->_iVersion);
			$encodeBufs['md5Password'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function passwordMatchMobile($md5Password,$mobile,$envDomainId,&$match,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("md5Password",1,$md5Password,$this->_iVersion);
			$encodeBufs['md5Password'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("mobile",2,$mobile,$this->_iVersion);
			$encodeBufs['mobile'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("envDomainId",3,$envDomainId,$this->_iVersion);
			$encodeBufs['envDomainId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$match = TUPAPIWrapper::getBool("match",4,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",5,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateProfile(UserInfo $ui,&$message) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("ui",1,$ui,$this->_iVersion);
			$encodeBufs['ui'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$message = TUPAPIWrapper::getString("message",2,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

