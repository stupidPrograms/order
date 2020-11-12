<?php

namespace App\Tars\cservant\BB\PosServer\ShopPos;

use Tars\client\CommunicatorConfig;
use Tars\client\Communicator;
use Tars\client\RequestPacket;
use Tars\client\TUPAPIWrapper;

use App\Tars\cservant\BB\PosServer\ShopPos\classes\PosListQuery;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\CommonInParam;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\ListInParam;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\PosList;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\CommonOutParam;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\PosApplications;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\PosClerksListQuery;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\ClerksList;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\AddClerk;
use App\Tars\cservant\BB\PosServer\ShopPos\classes\ClerksCheck;
class ShopPosServant {
	protected $_communicator;
	protected $_iVersion;
	protected $_iTimeout;
	public $_servantName = "BB.PosServer.ShopPos";

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

	public function PosList(PosListQuery $query,CommonInParam $inParam,ListInParam $param,PosList &$list,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("query",1,$query,$this->_iVersion);
			$encodeBufs['query'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("inParam",2,$inParam,$this->_iVersion);
			$encodeBufs['inParam'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("param",3,$param,$this->_iVersion);
			$encodeBufs['param'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("list",4,$list,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("outParam",5,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function PosApply(PosApplications $inParam,CommonOutParam &$outParam) {
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

	public function ClerksList(PosClerksListQuery $query,CommonInParam $inParam,ListInParam $param,ClerksList &$list,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("query",1,$query,$this->_iVersion);
			$encodeBufs['query'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("inParam",2,$inParam,$this->_iVersion);
			$encodeBufs['inParam'] = $__buffer;
			$__buffer = TUPAPIWrapper::putStruct("param",3,$param,$this->_iVersion);
			$encodeBufs['param'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("list",4,$list,$sBuffer,$this->_iVersion);
			$ret = TUPAPIWrapper::getStruct("outParam",5,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function AddClerks(AddClerk $clerk,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("clerk",1,$clerk,$this->_iVersion);
			$encodeBufs['clerk'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function EditRemark($id,$remark,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("id",1,$id,$this->_iVersion);
			$encodeBufs['id'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("remark",2,$remark,$this->_iVersion);
			$encodeBufs['remark'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",3,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function DelClerks($id,CommonOutParam &$outParam) {
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

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function IsConfirm($posId,AddClerk &$cl) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("posId",1,$posId,$this->_iVersion);
			$encodeBufs['posId'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("cl",2,$cl,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function Confirm(ClerksCheck $clerk,CommonOutParam &$outParam) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putStruct("clerk",1,$clerk,$this->_iVersion);
			$encodeBufs['clerk'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("outParam",2,$outParam,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function isPosUser($uuid,$code,CommonOutParam &$data) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putString("uuid",1,$uuid,$this->_iVersion);
			$encodeBufs['uuid'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("code",2,$code,$this->_iVersion);
			$encodeBufs['code'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",3,$data,$sBuffer,$this->_iVersion);
			return TUPAPIWrapper::getBool("",0,$sBuffer,$this->_iVersion);

		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function updateShopName($id,$name,CommonOutParam &$data) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$__buffer = TUPAPIWrapper::putInt32("id",1,$id,$this->_iVersion);
			$encodeBufs['id'] = $__buffer;
			$__buffer = TUPAPIWrapper::putString("name",2,$name,$this->_iVersion);
			$encodeBufs['name'] = $__buffer;
			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",3,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

	public function test(CommonOutParam &$data) {
		try {
			$requestPacket = new RequestPacket();
			$requestPacket->_iVersion = $this->_iVersion;
			$requestPacket->_funcName = __FUNCTION__;
			$requestPacket->_servantName = $this->_servantName;
			$encodeBufs = [];

			$requestPacket->_encodeBufs = $encodeBufs;

			$sBuffer = $this->_communicator->invoke($requestPacket,$this->_iTimeout);

			$ret = TUPAPIWrapper::getStruct("data",1,$data,$sBuffer,$this->_iVersion);
		}
		catch (\Exception $e) {
			throw $e;
		}
	}

}

