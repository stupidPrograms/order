<?php

namespace App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\resultMsg;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InUpdateUserAccount;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InGiveUserBuy;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InReleaseShopBuy;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InReceiveIntegral;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InWriteOffGive;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InTransaction;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\inputById;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\myPoints;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\inputintegra;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\pointsLists;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InReleasePropagation;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InNotify;
class IntegralTafServiceServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "IntegralSystem.IntegralServer.IntegralObj";

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

	public function testSever($in,resultMsg &$OurParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("in",1,$in,$this->_iVersion);
			$encodeBufs['in'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OurParams",2,$OurParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function notifyUserRegister($uuid,resultMsg &$OurParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OurParams",2,$OurParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateAccountInfo(InUpdateUserAccount $params,resultMsg &$OurParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("params",1,$params,$this->_iVersion);
			$encodeBufs['params'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OurParams",2,$OurParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function giveUserPointsBuy(InGiveUserBuy $InParams,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("InParams",1,$InParams,$this->_iVersion);
			$encodeBufs['InParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",2,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function releaseShopPointsBuy(InReleaseShopBuy $InParams,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("InParams",1,$InParams,$this->_iVersion);
			$encodeBufs['InParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",2,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function receiveIntegral(InReceiveIntegral $params,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("params",1,$params,$this->_iVersion);
			$encodeBufs['params'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",2,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function notifyShopRegister($shop_id,$domainId,resultMsg &$OurParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("shop_id",1,$shop_id,$this->_iVersion);
			$encodeBufs['shop_id'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("domainId",2,$domainId,$this->_iVersion);
			$encodeBufs['domainId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OurParams",3,$OurParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function giveIntegral($store_id,$points,$make,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("store_id",1,$store_id,$this->_iVersion);
			$encodeBufs['store_id'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("points",2,$points,$this->_iVersion);
			$encodeBufs['points'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("make",3,$make,$this->_iVersion);
			$encodeBufs['make'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",4,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function writeOffGivePoints(InWriteOffGive $InParams,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("InParams",1,$InParams,$this->_iVersion);
			$encodeBufs['InParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",2,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function integralTransaction(InTransaction $params,resultMsg &$OurParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("params",1,$params,$this->_iVersion);
			$encodeBufs['params'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OurParams",2,$OurParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function integralBalance(inputById $byId,myPoints &$points,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("byId",1,$byId,$this->_iVersion);
			$encodeBufs['byId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("points",2,$points,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("OutParams",3,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function integralLists(inputById $byId,inputintegra $input,resultMsg &$OutParams,pointsLists &$poinList) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("byId",1,$byId,$this->_iVersion);
			$encodeBufs['byId'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("input",2,$input,$this->_iVersion);
			$encodeBufs['input'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",3,$OutParams,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("poinList",4,$poinList,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function releasePropagation(InReleasePropagation $params,&$code,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("params",1,$params,$this->_iVersion);
			$encodeBufs['params'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$code = TUPAPIWrapper::getString("code",2,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("OutParams",3,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function notifyRecharge(InNotify $params,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("params",1,$params,$this->_iVersion);
			$encodeBufs['params'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",2,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function notifyDraw(InNotify $params,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("params",1,$params,$this->_iVersion);
			$encodeBufs['params'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",2,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

