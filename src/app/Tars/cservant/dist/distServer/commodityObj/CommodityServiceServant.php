<?php

namespace App\Tars\cservant\dist\distServer\commodityObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\dist\distServer\commodityObj\classes\CommonInParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\UpdateParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\CommonOutParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\PendingParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\PendingQueryParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\PendingPage;
use App\Tars\cservant\dist\distServer\commodityObj\classes\Config;
use App\Tars\cservant\dist\distServer\commodityObj\classes\ChangeStatusParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\QueryParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\Page;
use App\Tars\cservant\dist\distServer\commodityObj\classes\SynchronizeParam;
use App\Tars\cservant\dist\distServer\commodityObj\classes\Rate;
class CommodityServiceServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "dist.distServer.commodityObj";

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

	public function updateCommodity(CommonInParam $inParam,UpdateParam $param,CommonOutParam &$outParam) {
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

	public function updatePending(CommonInParam $inParam,UpdateParam $param,CommonOutParam &$outParam) {
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

	public function pending(CommonInParam $inParam,PendingParam $param,CommonOutParam &$outParam) {
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

	public function getPending(CommonInParam $inParam,PendingQueryParam $param,CommonOutParam &$outParam,PendingPage &$list) {
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
			$ret = TUPAPIWrapper::getStruct("list",4,$list,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getDefaultRate(CommonInParam $inParam,CommonOutParam &$outParam,&$list) {
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

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$list = TUPAPIWrapper::getVector("list",3,new \TARS_Vector(new Config()),$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateStatus(CommonInParam $inParam,ChangeStatusParam $param,CommonOutParam &$outParam) {
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

	public function getCommodity(CommonInParam $inParam,QueryParam $param,CommonOutParam &$outParam,Page &$list) {
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
			$ret = TUPAPIWrapper::getStruct("list",4,$list,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateDistGood(SynchronizeParam $param,CommonOutParam &$outParam) {
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
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getRate(CommonInParam $inParam,$commodityId,CommonOutParam &$outParam,Rate &$data) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParam",1,$inParam,$this->_iVersion);
			$encodeBufs['inParam'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("commodityId",2,$commodityId,$this->_iVersion);
			$encodeBufs['commodityId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("data",4,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

