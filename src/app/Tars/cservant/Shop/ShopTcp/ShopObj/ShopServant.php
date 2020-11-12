<?php

namespace App\Tars\cservant\Shop\ShopTcp\ShopObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\PageParam;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\ShopList;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\ShopInfo;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\resultMsg;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\outMerchantInfo;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\PageParamList;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\outProductList;
class ShopServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "Shop.ShopTcp.ShopObj";

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

	public function shopList(PageParam $Param,ShopList &$List) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("Param",1,$Param,$this->_iVersion);
			$encodeBufs['Param'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("List",2,$List,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function shopInfo($id,ShopInfo &$info) {
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

			$ret = TUPAPIWrapper::getStruct("info",2,$info,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function shopExis($uuid,resultMsg &$data) {
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

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function shopDomainId($shop_id,resultMsg &$data) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("shop_id",1,$shop_id,$this->_iVersion);
			$encodeBufs['shop_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function shopGetAppid($domain,resultMsg &$data) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("domain",1,$domain,$this->_iVersion);
			$encodeBufs['domain'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUuidShop($uuid,$name,$demain_id,ShopInfo &$ShopInfo) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("name",2,$name,$this->_iVersion);
			$encodeBufs['name'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("demain_id",3,$demain_id,$this->_iVersion);
			$encodeBufs['demain_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("ShopInfo",4,$ShopInfo,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function isMyShop($uuid,$shop_id,resultMsg &$data) {
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

			$ret = TUPAPIWrapper::getStruct("data",3,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getShopId($paramName,resultMsg &$data,&$outGetArrayId) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("paramName",1,$paramName,$this->_iVersion);
			$encodeBufs['paramName'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
			$outGetArrayId = TUPAPIWrapper::getVector("outGetArrayId",3,new \TARS_Vector(\TARS::INT32),$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function statisticsUpdated($store_id,$type,$updated,resultMsg &$data) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("store_id",1,$store_id,$this->_iVersion);
			$encodeBufs['store_id'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("type",2,$type,$this->_iVersion);
			$encodeBufs['type'] = $__buffer;
			$__buffer = TUPAPIWrapper::putInt32("updated",3,$updated,$this->_iVersion);
			$encodeBufs['updated'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",4,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getSubShop($pid,resultMsg &$data,&$outGetArrayId) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("pid",1,$pid,$this->_iVersion);
			$encodeBufs['pid'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
			$outGetArrayId = TUPAPIWrapper::getVector("outGetArrayId",3,new \TARS_Vector(\TARS::INT32),$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getDomainList($domain_id,resultMsg &$data,ShopList &$List) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("domain_id",1,$domain_id,$this->_iVersion);
			$encodeBufs['domain_id'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("List",3,$List,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getMerchantInfo($store_id,resultMsg &$data,outMerchantInfo &$Merchant) {
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

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("Merchant",3,$Merchant,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getShopProduct(PageParamList $Param,resultMsg &$data,outProductList &$ProductList) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("Param",1,$Param,$this->_iVersion);
			$encodeBufs['Param'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("ProductList",3,$ProductList,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getUuidShopList($type,$uuid,resultMsg &$data,ShopList &$List) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("type",1,$type,$this->_iVersion);
			$encodeBufs['type'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("uuid",2,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",3,$data,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("List",4,$List,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getMerchantIdShopInfo($MerchantId,resultMsg &$data,ShopInfo &$info) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("MerchantId",1,$MerchantId,$this->_iVersion);
			$encodeBufs['MerchantId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("info",3,$info,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

