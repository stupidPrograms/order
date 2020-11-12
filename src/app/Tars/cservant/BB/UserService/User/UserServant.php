<?php

namespace App\Tars\cservant\BB\UserService\User;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\BB\UserService\User\classes\UserBasic;
use App\Tars\cservant\BB\UserService\User\classes\UserInfo;
use App\Tars\cservant\BB\UserService\User\classes\UsersQueryParam;
use App\Tars\cservant\BB\UserService\User\classes\UserAccount;
use App\Tars\cservant\BB\UserService\User\classes\WechatUser;
use App\Tars\cservant\BB\UserService\User\classes\UserData;
class UserServant {
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

	public function getUserBasicByToken($token,$pathinfo,UserBasic &$user,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("token",1,$token,$this->_iVersion);
			$encodeBufs['token'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("pathinfo",2,$pathinfo,$this->_iVersion);
			$encodeBufs['pathinfo'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("user",3,$user,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUserInfoByToken($token,$pathinfo,UserInfo &$user,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("token",1,$token,$this->_iVersion);
			$encodeBufs['token'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("pathinfo",2,$pathinfo,$this->_iVersion);
			$encodeBufs['pathinfo'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("user",3,$user,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUserBasicByUuid($uuid,$envDomainId,UserBasic &$user,&$error) {
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
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("user",3,$user,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUserBasicListByQuery(UsersQueryParam $queryParam,&$list,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("queryParam",1,$queryParam,$this->_iVersion);
			$encodeBufs['queryParam'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$list = TUPAPIWrapper::getVector("list",2,new \TARS_Vector(new UserBasic()),$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUserInfoByUuid($uuid,$envDomainId,UserInfo &$user,&$error) {
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
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("user",3,$user,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUserInfoListByQuery(UsersQueryParam $queryParam,&$list,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("queryParam",1,$queryParam,$this->_iVersion);
			$encodeBufs['queryParam'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$list = TUPAPIWrapper::getVector("list",2,new \TARS_Vector(new UserInfo()),$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUserAccountByUuid($uuid,$envDomainId,UserAccount &$user,&$error) {
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
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("user",3,$user,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function mobileExists($mobile,$envDomainId,&$exists,&$error) {
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
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$exists = TUPAPIWrapper::getBool("exists",3,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getWechatUserByUuid($uuid,$domain,WechatUser &$wechatUser,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("domain",2,$domain,$this->_iVersion);
			$encodeBufs['domain'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("wechatUser",3,$wechatUser,$sBuffer,$this->_iVersion);
			$error = TUPAPIWrapper::getString("error",4,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateUserUuid($uuid,$mobile,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("mobile",2,$mobile,$this->_iVersion);
			$encodeBufs['mobile'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$error = TUPAPIWrapper::getString("error",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function generateUser(UserData $user_data,UserInfo &$user,&$error_msg) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("user_data",1,$user_data,$this->_iVersion);
			$encodeBufs['user_data'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("user",2,$user,$sBuffer,$this->_iVersion);
			$error_msg = TUPAPIWrapper::getString("error_msg",3,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUserInfoByMobile($mobile,UserInfo &$user) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("mobile",1,$mobile,$this->_iVersion);
			$encodeBufs['mobile'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("user",2,$user,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

