<?php

namespace App\Tars\servant\Coupon\CouponService\CouponTcp;

use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\publicErrorTips;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\singleCouponInfo;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\inProductId;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\availableCouponInfo;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\orderCouponIn;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\orderCouponOut;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\couponNumber;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\buyCouponIn;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\outParam;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\payCouponNotifyIn;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\couponUsedIn;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\updateOrderIdIn;
use App\Tars\servant\Coupon\CouponService\CouponTcp\classes\changeCouponStateIn;
interface CouponServant {
	/**
	 * @param int $coupon_id 
	 * @param struct $error_tips \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\publicErrorTips =out=
	 * @param struct $coupon_info \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\singleCouponInfo =out=
	 * @return void
	 */
	public function couponInfo($coupon_id,publicErrorTips &$error_tips,singleCouponInfo &$coupon_info);
	/**
	 * @param struct $product_id \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\inProductId
	 * @param struct $error_tips \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\publicErrorTips =out=
	 * @param struct $coupon_list \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\availableCouponInfo =out=
	 * @return void
	 */
	public function availableCouponInfo(inProductId $product_id,publicErrorTips &$error_tips,availableCouponInfo &$coupon_list);
	/**
	 * @param struct $inParam \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\orderCouponIn
	 * @param struct $outParam \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\orderCouponOut =out=
	 * @return void
	 */
	public function orderCouponInfo(orderCouponIn $inParam,orderCouponOut &$outParam);
	/**
	 * @param struct $product_id \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\inProductId
	 * @param struct $error_tips \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\publicErrorTips =out=
	 * @param struct $coupon_number \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\couponNumber =out=
	 * @return void
	 */
	public function couponNumber(inProductId $product_id,publicErrorTips &$error_tips,couponNumber &$coupon_number);
	/**
	 * @param struct $in \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\buyCouponIn
	 * @param struct $out \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\outParam =out=
	 * @return void
	 */
	public function buyCouponDataRecord(buyCouponIn $in,outParam &$out);
	/**
	 * @param struct $in \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\payCouponNotifyIn
	 * @param struct $out \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\outParam =out=
	 * @return void
	 */
	public function buyCouponNotify(payCouponNotifyIn $in,outParam &$out);
	/**
	 * @param struct $in \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\couponUsedIn
	 * @param struct $out \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\outParam =out=
	 * @return void
	 */
	public function couponUsedChangeState(couponUsedIn $in,outParam &$out);
	/**
	 * @param struct $in \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\updateOrderIdIn
	 * @param struct $out \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\outParam =out=
	 * @return void
	 */
	public function updateOrderId(updateOrderIdIn $in,outParam &$out);
	/**
	 * @param struct $in \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\changeCouponStateIn
	 * @param struct $out \App\Tars\servant\Coupon\CouponService\CouponTcp\classes\outParam =out=
	 * @return void
	 */
	public function changeCouponState(changeCouponStateIn $in,outParam &$out);
}

