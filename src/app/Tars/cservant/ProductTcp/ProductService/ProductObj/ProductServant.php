<?php

namespace App\Tars\cservant\ProductTcp\ProductService\ProductObj;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\PageParam;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\ProductList;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\ProductInfo;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\AttrInfo;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\UpdateData;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\StatusCode;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\resultMsg;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\paramList;
class ProductServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "ProductTcp.ProductService.ProductObj";

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

	public function productlist(PageParam $Param,ProductList &$List) {
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

	public function productdata($id,ProductInfo &$info) {
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

	public function attribute($id,AttrInfo &$Info) {
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

			$ret = TUPAPIWrapper::getStruct("Info",2,$Info,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateStock(UpdateData $Param,StatusCode &$CodeData) {
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

			$ret = TUPAPIWrapper::getStruct("CodeData",2,$CodeData,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getShopNum($store_id,resultMsg &$data) {
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
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function getProductList(paramList $param,resultMsg &$data,ProductList &$List) {
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

			$ret = TUPAPIWrapper::getStruct("data",2,$data,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("List",3,$List,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

