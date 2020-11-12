<?php

namespace App\Tars\cservant\PAY\PayService\PayTcp;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\PAY\PayService\PayTcp\classes\InUnify;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\Status;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\OutUnify;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\InOverageWithdraw;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\OutMechantOverage;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\InOrderPage;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\OutOrderPage;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\PayInfo;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\InSWIPE;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\InRefund;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\InPayQuery;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\inPosOrder;
class PayServiceServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "PAY.PayService.PayTcp";

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

	public function unify(InUnify $inParams,Status &$status,OutUnify &$outParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParams",1,$inParams,$this->_iVersion);
			$encodeBufs['inParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("status",2,$status,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("outParams",3,$outParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateOrderAmount($orderSn,$amount,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("orderSn",1,$orderSn,$this->_iVersion);
			$encodeBufs['orderSn'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("amount",2,$amount,$this->_iVersion);
			$encodeBufs['amount'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("status",3,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function integralWithdraw($openid,$amount,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("openid",1,$openid,$this->_iVersion);
			$encodeBufs['openid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("amount",2,$amount,$this->_iVersion);
			$encodeBufs['amount'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("status",3,$status,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getString("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function overageWithdraw(InOverageWithdraw $inParams,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParams",1,$inParams,$this->_iVersion);
			$encodeBufs['inParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("status",2,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function mechantOverage($merchantNo,OutMechantOverage &$outParams,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("merchantNo",1,$merchantNo,$this->_iVersion);
			$encodeBufs['merchantNo'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParams",2,$outParams,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("status",3,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function orderPages(InOrderPage $inParams,OutOrderPage &$outParams) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParams",1,$inParams,$this->_iVersion);
			$encodeBufs['inParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParams",2,$outParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function orderInfo($orderId,PayInfo &$outParams) {
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

			$ret = TUPAPIWrapper::getStruct("outParams",2,$outParams,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function appPayWxSWIPE(InSWIPE $inParams,OutUnify &$outParams,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParams",1,$inParams,$this->_iVersion);
			$encodeBufs['inParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParams",2,$outParams,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("status",3,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function appPayAlipaySWIPE(InSWIPE $inParams,OutUnify &$outParams,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParams",1,$inParams,$this->_iVersion);
			$encodeBufs['inParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParams",2,$outParams,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("status",3,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function appPayRefund(InRefund $inParams,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParams",1,$inParams,$this->_iVersion);
			$encodeBufs['inParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("status",2,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function appPayQuery(InPayQuery $inParams,Status &$status) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("inParams",1,$inParams,$this->_iVersion);
			$encodeBufs['inParams'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("status",2,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function posOrderQuery(inPosOrder $inParam,Status &$status) {
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

			$ret = TUPAPIWrapper::getStruct("status",2,$status,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

