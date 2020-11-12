<?php
namespace App\Services;

use App\Data\OrderData;
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderGoods;
use App\Models\OrderRecord;
use App\Tars\cservant\BB\Product\ProductTcp\classes\StatusCode;
use App\Tars\cservant\BB\Product\ProductTcp\classes\UpdateData;
use App\Tars\cservant\BB\Product\ProductTcp\ProductServant;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\resultMsg;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\ShopInfo;
use App\Tars\cservant\BB\Shop\ShopTcp\ShopServant;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\outParam;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\changeCouponStateIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\CouponServant;
use App\Tars\cservant\dist\distServer\performanceObj\classes\CommonOutParam;
use App\Tars\cservant\dist\distServer\performanceObj\classes\UpdateParam;
use App\Tars\cservant\dist\distServer\performanceObj\PerformanceServiceServant;
use App\Tars\Services\TarsHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class OrderService
{


    /**
     * 创建正常线上订单
     * @param $user
     * @param $uuid
     * @param $openid
     * @param $good_id
     * @param $goods_num
     * @param $sku_id
     * @param $dist_code
     * @param $address_id
     * @param $product_types
     * @param $coupon_id
     * @param $domain_id
     * @param $mobile
     * @param $order_type
     * @return OrderData
     * @throws \Exception
     */
    public static function createOrder($user,$uuid,$openid,$good_id,$goods_num, $sku_id, $dist_code, $address_id,$product_types,$coupon_id,$domain_id,$mobile,$order_type) {

        $obj = new OrderData($user,$uuid,$good_id,$goods_num, $sku_id, $dist_code, $address_id,$domain_id,$openid,$product_types,$coupon_id,0,$mobile,$order_type);

        //先获取订单数据
        $obj->getOrderData();

        //再生成对应的订单商品数据,这里要开启事务并提交。设置状态为订单已创建，待扣除库存
        $obj->getOrderGoodsData();

        //确定扣除库存后，设置状态为库存已扣除，待生成支付订单
        if ($obj->ensureStockIsDeducted()) {

            //库存扣除后再创建支付订单，这里只创建一次，后续用另外的线程去轮询看有没有漏创建的，需要补创建一下
            //最后把订单状态改为已生成支付订单，待支付
            if ($obj->ensurePaymentOrderIsCreated()) {

                //然后返回支付订单，先定时关闭一下订单
                $obj->deferCheckAndCloseUnpaidOrder();
            }
        }

        return $obj;
    }

    /**
     * 创建虚拟订单
     * @param $uuid
     * @param $pirce
     * @param $shop_id
     * @param $domain_id
     * @param $coupon_id
     * @param $mobile
     * @param $create_by_phone
     * @return OrderData
     * @throws \Exception
     */
    public static function createSaleOrder($uuid,$pirce,$shop_id,$domain_id,$coupon_id,$mobile,$create_by_phone){

        //初始化对象
        $obj = new OrderData(null,$uuid,0,0,0,'',0,$domain_id,'',1,$coupon_id,$shop_id);

        //初始化核销订单数据
        $obj->setSaleOrderData($pirce,$shop_id,$domain_id,$mobile,$create_by_phone);

        //核销订单数据入库
        $obj->createSaleOrderData();

        //虚拟商品创建支付订单
        $obj->ensurePaySaleOrder();

        return $obj;

    }

    /**
     * 创建秒杀订单
     * @param $user
     * @param $uuid
     * @param $good_id
     * @param $sku_id
     * @param $pay_online
     * @param $channel_code
     * @param $poster_code
     * @param $store_mobile
     * @return OrderData
     * @throws \Exception
     */
    public static function createSeckOrder($user,$uuid,$good_id,$sku_id,$pay_online,$channel_code,$poster_code,$store_mobile){

        //初始化对象
        $obj = new OrderData($user,$uuid,$good_id,1,$sku_id,null,0,1,'',1,0,0,'',4);

        //初始化秒杀订单数据
        $obj->getOrderData(null,$pay_online,$channel_code,$poster_code,$store_mobile);

        //秒杀订单数据提交
        $obj->createSeckOrder();

        //最后把订单状态改为已生成支付订单，待支付
        if ($obj->ensurePaymentOrderIsCreated()) {

            //然后返回支付订单，先定时关闭一下订单
            $obj->deferCheckAndCloseUnpaidOrder();
        }

        return  $obj;
    }

    /**
     * 创建拼团订单
     * @param $user
     * @param $uuid
     * @param $good_id
     * @param $sku_id
     * @param $pay_online
     * @param $code
     * @param $store_mobile
     * @return OrderData
     * @throws \Exception
     */
    public static function createGroupOrder($user,$uuid,$good_id,$sku_id,$pay_online,$code,$store_mobile){
        //初始化对象
        $obj = new OrderData($user,$uuid,$good_id,1,$sku_id,null,0,1,'',1,0,0,'',5);

        //初始化拼团订单数据
        $obj->getOrderData($code,$pay_online,$store_mobile);
        var_dump($sku_id);

        //拼团订单数据提交
        $obj->createSeckOrder();
        var_dump('lllllllllll啦啦啦');
        //最后把订单状态改为已生成支付订单，待支付
        if ($obj->ensurePaymentOrderIsCreated()) {
            var_dump('okokokuuu');

            //然后返回支付订单，先定时关闭一下订单
            $obj->deferCheckAndCloseUnpaidOrder();
        }

        return  $obj;
    }

    /**
     * 核销订单修改优惠券
     * @param $order_sn
     * @param $coupon_id
     * @return float|int
     * @throws \Exception
     */
    public static function updateSaleByCoupon($order_sn,$coupon_id){

        //验证订单
        $order = self::chechOrder($order_sn);

        if($order->status == 5) throw new BadRequestHttpException('该订单核销中，无法修改');

        $coupon = OrderCoupon::query()->where('order_id',$order->id)->first();

        if(!$coupon) throw new BadRequestHttpException('暂无该优惠券信息');

        //初始化对象
        $obj = new OrderData(null,$order->uuid,0,0,0,'',0,$order->env_domain_id,'',1,$coupon_id,$order->shop_id);

        //使用优惠券 , 计算订单的价格
        $coupon_money = $obj->getSalePrice($order->money);

        //修改优惠券支付金额
        $order->pay_offline     =   $coupon_money;
        $order->surplus_money   =   $coupon_money;

        //修改数据库优惠券信息，锁定选择优惠券，释放之前的优惠券
        $out = self::doCoupon($order->id,$order_sn,$coupon_id,$coupon->id);

        if($out) $order->save();

        //返回修改后的支付金额
        return number_format($coupon_money, 2, '.', '');
    }

    /**
     * 执行优惠券变更计划
     * @param $order_id
     * @param $order_sn
     * @param $newCou
     * @param $oldCou
     * @return bool
     */
    public static function doCoupon($order_id,$order_sn,$newCou,$oldCou){
        return true;

    }

    /**
     * 修改核销订单金额
     * @param $order_sn
     * @param $good_name
     * @param $price
     * @param $recipient
     * @param $address
     */
    public static function upOrderPirce($order_sn,$good_name,$price,$recipient,$address){
        //验证订单
        $order = self::chechOrder($order_sn);

        if($order->status == 5) throw new BadRequestHttpException('该订单核销中，无法修改');

        //修改订单支付金额
        $order->pay_online      =   $price;
        $order->pay_offline     =   $price;
        $order->surplus_money   =   $price;
        $order->recipient       =   $recipient;
        $order->address         =   $address;
        $order->hand_cost       =   $order->hand_rate * $price * 2;

        DB::beginTransaction();

        $upd = OrderGoods::query()->where('order_id',$order->id)->update([
            'goods_name'    =>  $good_name,
        ]);

        if(!$upd){
            DB::rollBack();
            throw new BadRequestHttpException('修改商品名称失败！');
        }

        $make = "修改核销订单支付金额";

        $set = self::addOrderRecord($order->id,'管理员',$order->phone,2,$make);

        if(!$set) {
            DB::rollBack();
            throw new BadRequestHttpException('修改金额失败');
        }

        $order->save();
        DB::commit();
    }

    /**
     * 核销订单结束
     * @param $store_id
     * @param $order_sn
     * @param $sale_code
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function endSaleOrder($store_id,$order_sn,$sale_code){

        //验证订单
        $order = self::chechOrder($order_sn,$sale_code,$store_id);

        //核销订单状态
        if($sale_code && $order->status == 4)   throw new BadRequestHttpException('该订单已核销');

        $make = "订单核销结束";

        $set = self::addOrderRecord($order->id,$order->recipient,$order->phone,3,$make);

        $order->paid    =   1;
        $order->status  =   4;

        if(!$set) throw new BadRequestHttpException('核销订单完成失败');

        $order->save();

        return  $order;
    }

    /**
     *  验证订单
     * @param null $order_sn
     * @param null $sale_code
     * @param int $store_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function chechOrder($order_sn = null,$sale_code = null,$store_id = 0){
        $model  = Order::query()->whereIn('status',[-5,-4,5]);

        if($store_id)   $model->where('shop_id',$store_id);

        if($order_sn){
            $model->where('ordersn',$order_sn);
        }else{
            $model->where('sale_code',$sale_code);
        }

        $order  =   $model->first([
            'id','ordersn','status','uuid','order_type','recipient','address','env_domain_id','shop_id','money','pay_online','pay_offline','surplus_money','create_by_phone','store_mobile'
        ]);

        if(!$order) throw new BadRequestHttpException('暂无该核销订单数据');

        return $order;
    }

    /**
     * 订单操作记录
     * @param $id
     * @param $recipient
     * @param $phone
     * @param $type
     * @param $make
     * @return bool
     */
    public static function addOrderRecord($id,$recipient,$phone,$type,$make){

        $datatime = date('Y-m-d H:i:s');
        //记录操作信息
        $data = [
            'order_id'      =>  $id,
            'operator'      =>  $recipient,
            'mobile'        =>  $phone,
            'record_type'   =>  $type,
            'comment'       =>  $make,
            'mark'          =>  $make,
            'created_at'    =>  $datatime,
            'updated_at'    =>  $datatime,
        ];

        $set = OrderRecord::query()->insert($data);

        return $set;
    }

    /**
     * 修改超时的订单状态为关闭状态
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function checkOffOrder($value){

        Order::query()->where(function ($query) use (&$value){

            $query->where('shop_id',$value)->orwhere('uuid',$value);

        })->where('paid',0)->where('status',0)->get(['id','ordersn','over_time','status','order_type'])
            ->each(function ($item){
                //关闭订单状态,同时回滚库存
                if($item->over_time < time()-10 ){

                    //秒杀订单通知秒杀系统做库存回滚
                    if($item->order_type == 4)    OrderService::doCallbackNotify($item->ordersn,-2);

                    //回滚库存,失败不错任何处理
                    if(in_array($item->order_type,[1,2])){
                        $remark     = "订单sn: ".$item->ordersn."超时未支付关闭，库存增加";
                        OrderService::upstock($item,$remark);

                        //若存在优惠券，则回滚优惠券
                        $hasCou =  OrderCoupon::query()->where('order_id',$item->id)->first('id');
                        if($hasCou) {
                            //修改优惠券状态,失败不做任何处理
                            OrderService::editCoupon($item->ordersn, 3);
                        }
                    }

                    $item->status = -2;
                    $item->save();
                }
            });
    }

    /**
     * 回滚库存
     * @param $order
     * @param $remark
     * @return StatusCode
     */
    public static function upstock($order,$remark){
        $product_servant        =   TarsHelper::servantFactory(ProductServant::class);
        $stock_data             =   new UpdateData;
        $CodeData               =   new StatusCode();

        $stock_data->id         =   $order->orderGood->goods_id;
        $stock_data->num        =   $order->orderGood->num;
        $stock_data->order_id   =   $order->orderGood->order_id;        //订单编号
        $stock_data->attr_id    =   $order->orderGood->sku_id;          //商品属性id
        $stock_data->type       =   1;
        $stock_data->remarks    =   $remark;                            //备注信息

        $product_servant->updateStock($stock_data,$CodeData);

        return $CodeData;
    }

    /**
     * 7天后为收货订单修改为已收货
     * @param $value
     */
    public static function confirmReceipt($value){

        Order::query()->where(function ($query) use (&$value){

            $query->where('shop_id',$value)->orwhere('uuid',$value);

        })->where('paid',1)->where('status',2)->get(['id','uuid','ordersn','paid_at','status'])
            ->each(function ($item) use (&$type){

                //计算时间:当前时间 - 支付时间
                $diff = time() - strtotime($item->paid_at);
                //超过一个星期的时间，则自动收货
                if($diff > 604800){
                    static::doConfirmReception($item->id,$item->uuid,1);
                    //通知支付系统
                    OrderService::unifiedShare($item->ordersn);
                }


            });
    }

    /**
     * 绑定第一次注册该平台，用户之前已有的虚拟订单
     * @param $uuid
     * @param $mobile
     */
    public static function checkSaleOrder($uuid,$mobile){
        Order::query()->select('id','uuid')->where('create_by_phone',$mobile)->whereIn('status',[-5,-4])->whereNull('uuid')->update(['uuid'=>$uuid]);
    }

    /**
     * 执行收货计划
     * @param $id
     * @param $uuid
     * @param int $type
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function doConfirmReception($id,$uuid,$type = 0){

        $order = Order::query()->where('id', $id)->where('uuid', $uuid)->where('status', 2)->first([
            'id','uuid','shop_id','env_domain_id','money','ordersn','gift_points','dist_code','recipient','phone','status'
        ]);

        if (!$order){

            if($type == 1) return false;

            throw new BadRequestHttpException('未找到对应订单');
        }

        try {
            //若是分销出去的商品,则走分销流程
            if($order['dist_code']){
                //商品分销
                $common = static::doDist($order);
                if ($common->code == 400) {
                    $order->update(['status' => 2]);

                    if($type == 1) return false;

                    throw new InvalidResourceException($common->message);
                }
            }

            $time = date('Y-m-d H:i:s');
            //记录操作信息
            $data = [
                'order_id'      =>  $id,
                'operator'      =>  $order->recipient,
                'mobile'        =>  $order->phone,
                'record_type'   =>  4,
                'comment'       =>  '确认收货',
                'mark'          =>  '确认收货',
                'created_at'    =>  $time,
                'updated_at'    =>  $time,

            ];

            if(!OrderRecord::query()->insert($data)){
                $order->update(['status' => 2]);

                if($type == 1) return false;

                throw new InvalidResourceException('确认收货失败');
            }

            //更新状态为已确认收货
            $order->update(['status' => 3]);
            return true;
        } catch (\Exception $e) {
            throw new InvalidResourceException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 商品分销
     * @param $order
     * @return CommonOutParam
     */
    public static function doDist($order){
        $performance_servant        =   TarsHelper::servantFactory(PerformanceServiceServant::class);
        $update_param               =   new UpdateParam;
        $update_param->tranId       =   $order['id'];
        $update_param->status       =   3;
        $update_param->points       =   $order['gift_points'] * 100;
        $update_param->businessId   =   $order['shop_id'];

        $common = new CommonOutParam;
        $performance_servant->updateRecord($update_param, $common);

        return $common;
    }

    /**
     * 修改优惠券状态
     * @param $order_sn
     * @param $state
     * @return outParam
     */
    public static function editCoupon($order_sn,$state){
        $couponServant    =   TarsHelper::servantFactory(CouponServant::class);
        $outParam         =   new outParam();
        $changeCou        =   new changeCouponStateIn();

        $changeCou->order_sn    = $order_sn;
        $changeCou->state       = $state;

        $couponServant->changeCouponState($changeCou,$outParam);

        return $outParam;
    }

    /**
     * 通知秒杀系统订单状态
     * @param $order_sn
     * @param $status
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function doCallbackNotify($order_sn,$status){
        try{

            $client     =   new Client();

            $url        =   config('tars.skill_host').'/Laravel/route/api/callbackNotify';

            $data       =   ['orderNo' =>  $order_sn,'status' => $status];

            //请求过去就行了，不做任何回调处理
            $client->request('post',$url,['query'  =>  $data]);


        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }


    /**
     * 通知秒杀系统订单状态
     * @param $order_sn
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getPickTIme($order_sn){
        try{

            $client     =   new Client();

            $url        =   config('tars.skill_host').'/Laravel/route/api/getPickTIme';

            $data       =   ['orderNo' =>  $order_sn];

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('post',$url,['query'  =>  $data]);

            $body       =   $request->getBody();
            $bodyStr    =   json_decode($body,true);

            return  $bodyStr;

        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 收货调用支付系统
     * @param $order_sn
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function unifiedShare($order_sn){

        try{

            $client     =   new Client();

            $url        =   env('PAY_HOST').'/Laravel/route/unifiedShare';

            $data       =   ['order_sn' =>  $order_sn];

            //请求过去就行了，不做任何回调处理
            $client->request('post',$url,['form_params'  =>  $data]);

        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 分销成功执行消息推送给用户
     * @param $order
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function doNoticeHttpBySale($order){
        $shopSvant    =   OrderService::getSopInfo($order->shop_id);
        $shop_name    =   $shopSvant->name;
        $good_name    =   $order->orderGood->goods_name;
        $pay_online   =   $order->pay_online;
        $user_phone   =   $order->create_by_phone;
        $store_mobile =   $shopSvant->mobile;

        //用户核销成功，发短信通知用户
        OrderService::doSendSmsHttp($shop_name,$good_name,$pay_online,$order->ordersn,$store_mobile,$user_phone);
        $content    =   "您的订单已完成，商家：{$shop_name}，商品：{$good_name}，订单合计：{$pay_online}元，订单号：{$order->ordersn}，如有疑问，请联系店铺客服（{$store_mobile}）。";

        $noticeData   =   [
            'platform'  =>  1,
            'role'      =>  2,
            'uuid'      =>  $order->uuid,
            'notice_type'  =>  1,
            'title'     =>  '订单消息',
            'subtitle'  =>  "商品名称 :{$good_name}",
            'content'   =>  json_encode($content),
            'sender'    =>  '邦邦科技',
        ];

        //站内消息推送
        OrderService::collectNoticeHttp($noticeData);
    }

    /**
     * 用户核销成功后 , 通知消息给用户
     * @param $business_name        .店铺名
     * @param $commodity_name       .商品名
     * @param $money                .订单合计
     * @param $number               .订单号
     * @param $phone_numbur         .请联系店铺客服
     * @param $mobile               .用户电话号
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function doSendSmsHttp($business_name,$commodity_name,$money,$number,$phone_numbur,$mobile){
        $template_param =   [
            'business_name'     =>  $business_name,
            'commodity_name'    =>  $commodity_name,
            'money'             =>  $money,
            'number'            =>  $number,
            'phone_numbur'      =>  $phone_numbur,
        ];

        $httpData   =   [
            'phone_numbers' =>  $mobile,
            'sign_name'     =>  '邦邦科技',
            'template_code' =>  'SMS_200186992',
            'template_param'=>  json_encode($template_param),
        ];

        self::sendSmsHttp($httpData);
    }

    /**
     * 下单支付成功执行消息推送给商家
     * @param $order_info
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function doNoticeHttpByOrder($order_info){
        //用户下单成功，发短信通知商家
        $good_name =    $order_info->orderGood->goods_name;
        $pay_online=    $order_info->pay_online;

        $template_param =   [
            'commodity_name'    =>  $good_name,
            'money'             =>  $pay_online,
        ];

        $httpData   =   [
            'phone_numbers' =>  $order_info->store_mobile,
            'sign_name'     =>  '邦邦科技',
            'template_code' =>  'SMS_200187033',
            'template_param'=>  json_encode($template_param),
        ];

        OrderService::sendSmsHttp($httpData);
        $content    =   "商品：{$good_name}，订单号：{$order_info->ordersn}，订单金额：{$pay_online}元请尽快处理";

        //站内消息推送
        $noticeData   =   [
            'platform'  =>  1,
            'role'      =>  1,
            'uuid'      =>  $order_info->business_id,
            'notice_type'  =>  1,
            'title'     =>  '订单消息',
            'subtitle'  =>  "商品名称 :{$good_name}",
            'content'   =>  json_encode($content),
            'sender'    =>  '邦邦科技',
        ];
        OrderService::collectNoticeHttp($noticeData);
    }

    /**
     * 阿里SMS短信发送
     * @param $data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendSmsHttp($data){
        try{

            $client     =   new Client();

            $url        =   env('NOTICE_HOST').'/Laravel/notice/sendSms';

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('post',$url,['form_params'  =>  $data]);
            $body       =   $request->getBody();
            $bodyStr    =   (string)$body;

            var_dump($bodyStr);
        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 上报站内消息
     * @param $data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function collectNoticeHttp($data){
        try{

            $client     =   new Client();

            $url        =   env('NOTICE_HOST').'/Laravel/notice/collectNotice';

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('post',$url,['form_params'  =>  $data]);
            $body       =   $request->getBody();
            $bodyStr    =   (string)$body;

            var_dump($bodyStr);
        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 分销佣金获得
     * @param $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function integralHold($data){
        try{

            $client     =   new Client();

            $url        =   env('INTEGRAL_HOST').'/Laravel/integral/integralHold';

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('post',$url,['form_params'  =>  $data]);
            $body       =   $request->getBody();
            $bodyStr    =   (string)$body;

            var_dump($bodyStr);
            return  $bodyStr;
        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 获取店铺信息
     * @param $store_id
     * @return ShopInfo
     */
    public static function getSopInfo($store_id){
        $shopService   =    TarsHelper::servantFactory(ShopServant::class);
        $resultMsg     =    new resultMsg();
        $shopInfo      =    new ShopInfo();

        $shopService->shopInfo($store_id,$resultMsg,$shopInfo);

        if($resultMsg->msg == '店铺不存在') throw new BadRequestHttpException('店铺不存在');

        return $shopInfo;
    }

}
