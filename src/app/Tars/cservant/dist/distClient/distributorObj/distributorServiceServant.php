<?php

namespace App\Tars\cservant\dist\distClient\distributorObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\dist\distClient\distributorObj\classes\distributors;
use App\Tars\cservant\dist\distClient\distributorObj\classes\CommonOutParam;
use App\Tars\cservant\dist\distClient\distributorObj\classes\myInfo;
use App\Tars\cservant\dist\distClient\distributorObj\classes\friendQrCode;
use App\Tars\cservant\dist\distClient\distributorObj\classes\outShopData;
use App\Tars\cservant\dist\distClient\distributorObj\classes\commodity;
use App\Tars\cservant\dist\distClient\distributorObj\classes\productLists;
use App\Tars\cservant\dist\distClient\distributorObj\classes\goodOne;
use App\Tars\cservant\dist\distClient\distributorObj\classes\productList;
use App\Tars\cservant\dist\distClient\distributorObj\classes\inputQrCode;
class distributorServiceServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "dist.distClient.distributorObj";

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

	public function applyDistributor(distributors $dist,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("dist",1,$dist,$this->_iVersion);
			$encodeBufs['dist'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function repeatApplyDist(myInfo $my,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("my",1,$my,$this->_iVersion);
			$encodeBufs['my'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function checkMobile($mobile,$domainId,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("mobile",1,$mobile,$this->_iVersion);
			$encodeBufs['mobile'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("domainId",2,$domainId,$this->_iVersion);
			$encodeBufs['domainId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function checkDist(myInfo $Info,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("Info",1,$Info,$this->_iVersion);
			$encodeBufs['Info'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function friendQrCode(myInfo $Info,CommonOutParam &$outParam,friendQrCode &$friend) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("Info",1,$Info,$this->_iVersion);
			$encodeBufs['Info'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("friend",3,$friend,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function shopInfo($businessId,$domainId,CommonOutParam &$outParam,outShopData &$ShopData) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("businessId",1,$businessId,$this->_iVersion);
			$encodeBufs['businessId'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("domainId",2,$domainId,$this->_iVersion);
			$encodeBufs['domainId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("ShopData",4,$ShopData,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getCommodity(commodity $comm,CommonOutParam &$outParam,productLists &$list) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("comm",1,$comm,$this->_iVersion);
			$encodeBufs['comm'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("list",3,$list,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function commodityDetails(goodOne $good,CommonOutParam &$outParam,productList &$produc) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("good",1,$good,$this->_iVersion);
			$encodeBufs['good'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("produc",3,$produc,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function QrCode(goodOne $good,CommonOutParam &$outParam,inputQrCode &$QrCode) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("good",1,$good,$this->_iVersion);
			$encodeBufs['good'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("QrCode",3,$QrCode,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function demo(goodOne $good,CommonOutParam &$outParam,productList &$product) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("good",1,$good,$this->_iVersion);
			$encodeBufs['good'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("product",3,$product,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

