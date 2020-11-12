<?php

namespace App\Tars\cservant\dist\distClient\personalObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\dist\distClient\personalObj\classes\inputMyCenter;
use App\Tars\cservant\dist\distClient\personalObj\classes\CommonOutParam;
use App\Tars\cservant\dist\distClient\personalObj\classes\outMyCenter;
use App\Tars\cservant\dist\distClient\personalObj\classes\outMyInfo;
use App\Tars\cservant\dist\distClient\personalObj\classes\inputRecords;
use App\Tars\cservant\dist\distClient\personalObj\classes\outRecords;
use App\Tars\cservant\dist\distClient\personalObj\classes\inputBusiness;
use App\Tars\cservant\dist\distClient\personalObj\classes\outBusiness;
use App\Tars\cservant\dist\distClient\personalObj\classes\inputRelieve;
class PersonalServiceServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "dist.distClient.personalObj";

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

	public function mySelfCenter(inputMyCenter $input,CommonOutParam &$outParam,outMyCenter &$MyCenter) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("input",1,$input,$this->_iVersion);
			$encodeBufs['input'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("MyCenter",3,$MyCenter,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function mySelfInfo(inputMyCenter $input,CommonOutParam &$outParam,outMyInfo &$MyInfo) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("input",1,$input,$this->_iVersion);
			$encodeBufs['input'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("MyInfo",3,$MyInfo,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function mySelfRecords(inputRecords $record,CommonOutParam &$outParam,outRecords &$Records) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("record",1,$record,$this->_iVersion);
			$encodeBufs['record'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("Records",3,$Records,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function businessList(inputMyCenter $input,inputBusiness $busi,CommonOutParam &$outParam,outBusiness &$Business) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("input",1,$input,$this->_iVersion);
			$encodeBufs['input'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("busi",2,$busi,$this->_iVersion);
			$encodeBufs['busi'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("Business",4,$Business,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function disengagement(inputRelieve $relieve,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("relieve",1,$relieve,$this->_iVersion);
			$encodeBufs['relieve'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function test(inputMyCenter $input,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("input",1,$input,$this->_iVersion);
			$encodeBufs['input'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

