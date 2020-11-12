<?php

namespace App\Tars\servant\Shop\ShopTcp\ShopObj;

use App\Tars\servant\Shop\ShopTcp\ShopObj\classes\PageParam;
use App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopList;
use App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopInfo;
use App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg;
use App\Tars\servant\Shop\ShopTcp\ShopObj\classes\outMerchantInfo;
use App\Tars\servant\Shop\ShopTcp\ShopObj\classes\PageParamList;
use App\Tars\servant\Shop\ShopTcp\ShopObj\classes\outProductList;
interface ShopServant {
	/**
	 * @param struct $Param \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\PageParam
	 * @param struct $List \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopList =out=
	 * @return void
	 */
	public function shopList(PageParam $Param,ShopList &$List);
	/**
	 * @param int $id 
	 * @param struct $info \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopInfo =out=
	 * @return void
	 */
	public function shopInfo($id,ShopInfo &$info);
	/**
	 * @param string $uuid 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @return void
	 */
	public function shopExis($uuid,resultMsg &$data);
	/**
	 * @param int $shop_id 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @return void
	 */
	public function shopDomainId($shop_id,resultMsg &$data);
	/**
	 * @param string $domain 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @return void
	 */
	public function shopGetAppid($domain,resultMsg &$data);
	/**
	 * @param string $uuid 
	 * @param string $name 
	 * @param int $demain_id 
	 * @param struct $ShopInfo \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopInfo =out=
	 * @return void
	 */
	public function getUuidShop($uuid,$name,$demain_id,ShopInfo &$ShopInfo);
	/**
	 * @param string $uuid 
	 * @param int $shop_id 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @return void
	 */
	public function isMyShop($uuid,$shop_id,resultMsg &$data);
	/**
	 * @param string $paramName 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @param vector $outGetArrayId \TARS_Vector(\TARS::INT32) =out=
	 * @return void
	 */
	public function getShopId($paramName,resultMsg &$data,&$outGetArrayId);
	/**
	 * @param int $store_id 
	 * @param int $type 
	 * @param int $updated 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @return void
	 */
	public function statisticsUpdated($store_id,$type,$updated,resultMsg &$data);
	/**
	 * @param int $pid 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @param vector $outGetArrayId \TARS_Vector(\TARS::INT32) =out=
	 * @return void
	 */
	public function getSubShop($pid,resultMsg &$data,&$outGetArrayId);
	/**
	 * @param int $domain_id 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @param struct $List \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopList =out=
	 * @return void
	 */
	public function getDomainList($domain_id,resultMsg &$data,ShopList &$List);
	/**
	 * @param int $store_id 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @param struct $Merchant \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\outMerchantInfo =out=
	 * @return void
	 */
	public function getMerchantInfo($store_id,resultMsg &$data,outMerchantInfo &$Merchant);
	/**
	 * @param struct $Param \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\PageParamList
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @param struct $ProductList \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\outProductList =out=
	 * @return void
	 */
	public function getShopProduct(PageParamList $Param,resultMsg &$data,outProductList &$ProductList);
	/**
	 * @param int $type 
	 * @param string $uuid 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @param struct $List \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopList =out=
	 * @return void
	 */
	public function getUuidShopList($type,$uuid,resultMsg &$data,ShopList &$List);
	/**
	 * @param string $MerchantId 
	 * @param struct $data \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\resultMsg =out=
	 * @param struct $info \App\Tars\servant\Shop\ShopTcp\ShopObj\classes\ShopInfo =out=
	 * @return void
	 */
	public function getMerchantIdShopInfo($MerchantId,resultMsg &$data,ShopInfo &$info);
}

