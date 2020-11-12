<?php

namespace App\Tars\servant\BB\Shop\ShopTcp;

use App\Tars\servant\BB\Shop\ShopTcp\classes\resultMsg;
use App\Tars\servant\BB\Shop\ShopTcp\classes\outShopConfig;
use App\Tars\servant\BB\Shop\ShopTcp\classes\ShopInfo;
use App\Tars\servant\BB\Shop\ShopTcp\classes\outMerchantInfo;
interface ShopServant {
	/**
	 * @param int $store_id 
	 * @param struct $data \App\Tars\servant\BB\Shop\ShopTcp\classes\resultMsg =out=
	 * @param struct $ShopConfig \App\Tars\servant\BB\Shop\ShopTcp\classes\outShopConfig =out=
	 * @return void
	 */
	public function getShopConfig($store_id,resultMsg &$data,outShopConfig &$ShopConfig);
	/**
	 * @param string $uuid 
	 * @param struct $data \App\Tars\servant\BB\Shop\ShopTcp\classes\resultMsg =out=
	 * @return void
	 */
	public function shopExis($uuid,resultMsg &$data);
	/**
	 * @param int $id 
	 * @param struct $data \App\Tars\servant\BB\Shop\ShopTcp\classes\resultMsg =out=
	 * @param struct $info \App\Tars\servant\BB\Shop\ShopTcp\classes\ShopInfo =out=
	 * @return void
	 */
	public function shopInfo($id,resultMsg &$data,ShopInfo &$info);
	/**
	 * @param int $store_id 
	 * @param struct $data \App\Tars\servant\BB\Shop\ShopTcp\classes\resultMsg =out=
	 * @param struct $Merchant \App\Tars\servant\BB\Shop\ShopTcp\classes\outMerchantInfo =out=
	 * @return void
	 */
	public function getMerchantInfo($store_id,resultMsg &$data,outMerchantInfo &$Merchant);
	/**
	 * @param int $pid 
	 * @param struct $data \App\Tars\servant\BB\Shop\ShopTcp\classes\resultMsg =out=
	 * @param vector $outGetArrayId \TARS_Vector(\TARS::INT32) =out=
	 * @return void
	 */
	public function getSubShop($pid,resultMsg &$data,&$outGetArrayId);
}

