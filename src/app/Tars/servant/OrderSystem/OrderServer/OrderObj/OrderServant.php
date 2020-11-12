<?php

namespace App\Tars\servant\OrderSystem\OrderServer\OrderObj;

use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InNotifyData;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InSearch;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OutOrderList;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OutOrderInfo;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InUpdateOrder;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\outConsumption;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\outMoney;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\orderCounts;
interface OrderServant {
	/**
	 * @param string $in 
	 * @param string $OutParams =out=
	 * @return void
	 */
	public function testInterface($in,&$OutParams);
	/**
	 * @param struct $InParam \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InNotifyData
	 * @param struct $OutParams \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function notifyOrderPayment(InNotifyData $InParam,resultMsg &$OutParams);
	/**
	 * @param struct $InParams \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InSearch
	 * @param struct $OrderList \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OutOrderList =out=
	 * @param struct $result \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function OrderList(InSearch $InParams,OutOrderList &$OrderList,resultMsg &$result);
	/**
	 * @param int $id 
	 * @param struct $OrderInfo \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OutOrderInfo =out=
	 * @param struct $result \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function OrderInfo($id,OutOrderInfo &$OrderInfo,resultMsg &$result);
	/**
	 * @param struct $InParams \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InUpdateOrder
	 * @param struct $OurParams \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function updateOrder(InUpdateOrder $InParams,resultMsg &$OurParams);
	/**
	 * @param string $uuid 
	 * @param int $shop_id 
	 * @param struct $cons \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\outConsumption =out=
	 * @param struct $ressult \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function userConstion($uuid,$shop_id,outConsumption &$cons,resultMsg &$ressult);
	/**
	 * @param int $store_id 
	 * @param struct $result \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @param struct $Moneys \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\outMoney =out=
	 * @return void
	 */
	public function totalMoney($store_id,resultMsg &$result,outMoney &$Moneys);
	/**
	 * @param string $orderSn 
	 * @param struct $result \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function checkOrder($orderSn,resultMsg &$result);
	/**
	 * @param int $orderId 
	 * @param struct $result \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function checkSett($orderId,resultMsg &$result);
	/**
	 * @param int $stord_id 
	 * @param int $points 
	 * @param int $domainid 
	 * @param struct $result \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @return void
	 */
	public function setNotSett($stord_id,$points,$domainid,resultMsg &$result);
	/**
	 * @param int $stord_id 
	 * @param int $good_id 
	 * @param struct $result \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg =out=
	 * @param struct $orderCount \App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\orderCounts =out=
	 * @return void
	 */
	public function getOrderCount($stord_id,$good_id,resultMsg &$result,orderCounts &$orderCount);
}

