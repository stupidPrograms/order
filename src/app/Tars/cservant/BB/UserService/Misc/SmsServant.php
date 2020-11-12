<?php

namespace App\Tars\cservant\BB\UserService\Misc;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

class SmsServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "BB.UserService.Misc";

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

	public function sendSms($to,$content,$template,$data,&$error) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("to",1,$to,$this->_iVersion);
			$encodeBufs['to'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("content",2,$content,$this->_iVersion);
			$encodeBufs['content'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("template",3,$template,$this->_iVersion);
			$encodeBufs['template'] = $__buffer;
			$data_map = new \TARS_Map(\TARS::STRING,\TARS::STRING);
			foreach($data as $key => $value) {
				$data_map->pushBack([$key => $value]);
			}
			$__buffer = TUPAPIWrapper::putMap("data",4,$data_map,$this->_iVersion);
			$encodeBufs['data'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$error = TUPAPIWrapper::getString("error",5,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getInt32("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

