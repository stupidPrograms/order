<?php

namespace App\Tars\cservant\Coupon\CouponService\CouponTcp;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\publicErrorTips;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\singleCouponInfo;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\inProductId;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\availableCouponInfo;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\orderCouponIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\orderCouponOut;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\couponNumber;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\buyCouponIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\outParam;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\payCouponNotifyIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\couponUsedIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\updateOrderIdIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\changeCouponStateIn;
class CouponServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "Coupon.CouponService.CouponTcp";

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

	public function couponInfo($coupon_id,publicErrorTips &$error_tips,singleCouponInfo &$coupon_info) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("coupon_id",1,$coupon_id,$this->_iVersion);
			$encodeBufs['coupon_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("error_tips",2,$error_tips,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("coupon_info",3,$coupon_info,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function availableCouponInfo(inProductId $product_id,publicErrorTips &$error_tips,availableCouponInfo &$coupon_list) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("product_id",1,$product_id,$this->_iVersion);
			$encodeBufs['product_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("error_tips",2,$error_tips,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("coupon_list",3,$coupon_list,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function orderCouponInfo(orderCouponIn $inParam,orderCouponOut &$outParam) {
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
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function couponNumber(inProductId $product_id,publicErrorTips &$error_tips,couponNumber &$coupon_number) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("product_id",1,$product_id,$this->_iVersion);
			$encodeBufs['product_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("error_tips",2,$error_tips,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("coupon_number",3,$coupon_number,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function buyCouponDataRecord(buyCouponIn $in,outParam &$out) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("in",1,$in,$this->_iVersion);
			$encodeBufs['in'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("out",2,$out,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function buyCouponNotify(payCouponNotifyIn $in,outParam &$out) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("in",1,$in,$this->_iVersion);
			$encodeBufs['in'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("out",2,$out,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function couponUsedChangeState(couponUsedIn $in,outParam &$out) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("in",1,$in,$this->_iVersion);
			$encodeBufs['in'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("out",2,$out,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateOrderId(updateOrderIdIn $in,outParam &$out) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("in",1,$in,$this->_iVersion);
			$encodeBufs['in'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("out",2,$out,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function changeCouponState(changeCouponStateIn $in,outParam &$out) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("in",1,$in,$this->_iVersion);
			$encodeBufs['in'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("out",2,$out,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

