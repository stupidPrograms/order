<?php

namespace App\Tars\cservant\ApiServer\BaseService\obj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

class BaseServiceServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "ApiServer.BaseService.obj";

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

	public function api_register($upstream_name,$hostname,$port,$service_name,$service_path,$route_paths) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("upstream_name",1,$upstream_name,$this->_iVersion);
			$encodeBufs['upstream_name'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("hostname",2,$hostname,$this->_iVersion);
			$encodeBufs['hostname'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("port",3,$port,$this->_iVersion);
			$encodeBufs['port'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("service_name",4,$service_name,$this->_iVersion);
			$encodeBufs['service_name'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("service_path",5,$service_path,$this->_iVersion);
			$encodeBufs['service_path'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("route_paths",6,$route_paths,$this->_iVersion);
			$encodeBufs['route_paths'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function api_add_consumer($consumer_name) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("consumer_name",1,$consumer_name,$this->_iVersion);
			$encodeBufs['consumer_name'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

