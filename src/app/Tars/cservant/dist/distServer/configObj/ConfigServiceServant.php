<?php

namespace App\Tars\cservant\dist\distServer\configObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\dist\distServer\configObj\classes\CommonInParam;
use App\Tars\cservant\dist\distServer\configObj\classes\CommonOutParam;
use App\Tars\cservant\dist\distServer\configObj\classes\Level;
use App\Tars\cservant\dist\distServer\configObj\classes\QueryParam;
use App\Tars\cservant\dist\distServer\configObj\classes\PendingParam;
class ConfigServiceServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "dist.distServer.configObj";

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

	public function getLevel(CommonInParam $inParam,&$data,CommonOutParam &$outParam,&$type) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParam",1,$inParam,$this->_iVersion);
			$encodeBufs['inParam'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$data = TUPAPIWrapper::getVector("data",2,new \TARS_Vector(new Level()),$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
			$type = TUPAPIWrapper::getInt32("type",4,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateConfig(CommonInParam $inParam,QueryParam $param,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParam",1,$inParam,$this->_iVersion);
			$encodeBufs['inParam'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("param",2,$param,$this->_iVersion);
			$encodeBufs['param'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function changeStatus(CommonInParam $param,$status,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("param",1,$param,$this->_iVersion);
			$encodeBufs['param'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("status",2,$status,$this->_iVersion);
			$encodeBufs['status'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getStatus(CommonInParam $param,CommonOutParam &$outParam,&$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("param",1,$param,$this->_iVersion);
			$encodeBufs['param'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$status = TUPAPIWrapper::getInt32("status",3,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updatePendingConfig(CommonInParam $inParam,PendingParam $param,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParam",1,$inParam,$this->_iVersion);
			$encodeBufs['inParam'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("param",2,$param,$this->_iVersion);
			$encodeBufs['param'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

