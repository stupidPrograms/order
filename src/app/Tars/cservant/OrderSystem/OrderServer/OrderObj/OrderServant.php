<?php

namespace App\Tars\cservant\OrderSystem\OrderServer\OrderObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\InNotifyData;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\resultMsg;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\InSearch;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\OutOrderList;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\OutOrderInfo;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\InUpdateOrder;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\outConsumption;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\outMoney;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\orderCounts;
class OrderServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "OrderSystem.OrderServer.OrderObj";

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

	public function testInterface($in,&$OutParams) {
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

			$OutParams = TUPAPIWrapper::getString("OutParams",2,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function notifyOrderPayment(InNotifyData $InParam,resultMsg &$OutParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("InParam",1,$InParam,$this->_iVersion);
			$encodeBufs['InParam'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OutParams",2,$OutParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function OrderList(InSearch $InParams,OutOrderList &$OrderList,resultMsg &$result) {
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

			$ret = TUPAPIWrapper::getStruct("OrderList",2,$OrderList,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("result",3,$result,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function OrderInfo($id,OutOrderInfo &$OrderInfo,resultMsg &$result) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("id",1,$id,$this->_iVersion);
			$encodeBufs['id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("OrderInfo",2,$OrderInfo,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("result",3,$result,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateOrder(InUpdateOrder $InParams,resultMsg &$OurParams) {
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

			$ret = TUPAPIWrapper::getStruct("OurParams",2,$OurParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function userConstion($uuid,$shop_id,outConsumption &$cons,resultMsg &$ressult) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("shop_id",2,$shop_id,$this->_iVersion);
			$encodeBufs['shop_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("cons",3,$cons,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("ressult",4,$ressult,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function totalMoney($store_id,resultMsg &$result,outMoney &$Moneys) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("store_id",1,$store_id,$this->_iVersion);
			$encodeBufs['store_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("result",2,$result,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("Moneys",3,$Moneys,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function checkOrder($orderSn,resultMsg &$result) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("orderSn",1,$orderSn,$this->_iVersion);
			$encodeBufs['orderSn'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("result",2,$result,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function checkSett($orderId,resultMsg &$result) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("orderId",1,$orderId,$this->_iVersion);
			$encodeBufs['orderId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("result",2,$result,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function setNotSett($stord_id,$points,$domainid,resultMsg &$result) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("stord_id",1,$stord_id,$this->_iVersion);
			$encodeBufs['stord_id'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("points",2,$points,$this->_iVersion);
			$encodeBufs['points'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("domainid",3,$domainid,$this->_iVersion);
			$encodeBufs['domainid'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("result",4,$result,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getOrderCount($stord_id,$good_id,resultMsg &$result,orderCounts &$orderCount) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("stord_id",1,$stord_id,$this->_iVersion);
			$encodeBufs['stord_id'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("good_id",2,$good_id,$this->_iVersion);
			$encodeBufs['good_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("result",3,$result,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("orderCount",4,$orderCount,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

