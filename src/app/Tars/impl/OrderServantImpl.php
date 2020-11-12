<?php

namespace App\Tars\impl;


use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\OrderRecord;
use App\Models\OrderHirePur;
use App\Models\OrderSon;
use App\Services\OrderService;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\ShopInfo;
use App\Tars\cservant\dist\distServer\performanceObj\classes\CommonOutParam;
use App\Tars\cservant\dist\distServer\performanceObj\classes\distInteger;
use App\Tars\cservant\dist\distServer\performanceObj\classes\RecordParam;
use App\Tars\cservant\dist\distServer\performanceObj\classes\UpdateParam;
use App\Tars\cservant\dist\distServer\performanceObj\PerformanceServiceServant;
use App\Tars\cservant\Integral\Integral\IntegralTcp\classes\outParam;
use App\Tars\cservant\Integral\Integral\IntegralTcp\classes\integralHoldIn;
use App\Tars\cservant\Integral\Integral\IntegralTcp\IntegralServant;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InGiveUserBuy;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InReleaseShopBuy;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InTransaction;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InWriteOffGive;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\IntegralTafServiceServant;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InNotifyData;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InSearch;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\InUpdateOrder;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\orderCounts;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OrderGoods as OrderGoodsStruct;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OutConsumption;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\outMoney;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OutOrderInfo;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\OutOrderList;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\inputById;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\myPoints;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\resultMsg as IntegralRes;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\OrderServant;
use App\Tars\Services\TarsHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Illuminate\Support\Facades\Validator;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\ShopServant;
use App\Tars\cservant\PAY\PayService\PayTcp\PayServiceServant;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\OutMechantOverage;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\Status;
use App\Tars\cservant\dist\distServer\performanceObj\classes\amounts;
use GuzzleHttp\Client;

class OrderServantImpl implements OrderServant{

    public function testInterface($in, &$OutParams)
    {
        var_dump(1111111);
        $OutParams = 'hello'.$in;
    }

    /**
     * 支付回调
     * @param InNotifyData $InParam
     * @param resultMsg $OutParams
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function notifyOrderPayment(InNotifyData $InParam, resultMsg &$OutParams)
    {
        try{

            var_dump('走到回调！');

            $select =   ['id','shop_id','uuid','recipient','phone','order_type','ordersn','status','gift_points','dist_code','sale_code','store_mobile','business_id',
                'pay_online','money','dist_code','env_domain_id','order_type','hand_cost','business_id','create_by_phone'];

            $order_info = Order::query()->select($select)->where('pay_ordersn', $InParam->ordersn)->first();

            if ($order_info->status !== 0) {
                throw new BadRequestHttpException('订单不是待支付状态');
            }

            $upData = [
                'paid'      => 1,
                'paid_type' => $InParam->paid_type,
                'paid_at'   => Carbon::now(),
            ];

            if (in_array($order_info->order_type,[2,4,5])){
                $upData['status']   = '-4';
            }else if ($order_info->order_type == 1){
                $upData['status']   = '1';
            }

            DB::beginTransaction();

            $res = Order::query()->where('pay_ordersn', $InParam->ordersn)->update($upData);
            if (!$res){
                DB::rollBack();
                throw new BadRequestHttpException('数据更新失败');
            }

            $nowTime = date('Y-m-d H:i:s');
            //记录操作信息
            $setData = [
                'order_id'      =>  $order_info->id,
                'operator'      =>  $order_info->recipient,
                'mobile'        =>  $order_info->phone,
                'record_type'   =>  4,
                'comment'       =>  '已支付金额',
                'mark'          =>  '已支付金额',
                'created_at'    =>  $nowTime,
                'updated_at'    =>  $nowTime,

            ];

            if(!OrderRecord::query()->insert($setData)){
                DB::rollBack();
                throw new \Exception('订单数据记录失败');
            }

            DB::commit();

            //用户下单成功，发短信通知商家
            if($order_info->store_mobile)   OrderService::doNoticeHttpByOrder($order_info);

            //商家uuid
            $business_id  =  $order_info->business_id;

            //扣除手续费(扣除商家积分)
            if($order_info->hand_cost > 0)   $this->updateIntegral($business_id,$order_info->hand_cost);

            //秒杀订单通知秒杀系统支付成功
            if($order_info->order_type == 4)    OrderService::doCallbackNotify($InParam->ordersn,2);

            //拼团订单回调
            if($order_info->order_type == 5){
                var_dump('拼团回调');
                $this->doGroupOrder($order_info->ordersn);
            }

            //记录分销记录
            if ($order_info->dist_code)
            {
                //記錄分銷信息
                $distInteger = $this->recordDist($order_info,$OutParams);

                $shop_id    =   $order_info->shop_id;
                $goods_name =   $order_info->orderGood->goods_name;
                $mobile     =   $order_info->create_by_phone;
                //积分发放给用户
                //一级分销员获得佣金
                if($distInteger->one_integer){
                    //$this->integralHold($distInteger->one_dist,$shop_id,$distInteger->task_code,$distInteger->one_integer/100,$goods_name,$mobile);
                    OrderService::integralHold([
                        "integral_task_id"  =>  $distInteger->task_code,
                        "uuid"              =>  $distInteger->one_dist,
                        "merchant_id"       =>  $shop_id,
                        "shop_id"           =>  $shop_id,
                        "reduce_integral"   =>  $distInteger->one_integer/100,
                        "user_phone"        =>  $mobile,
                        "type"              =>   "4",
                        "desc"              =>  "商家派发积分给分销员",
                        "status"            =>  "2"
                    ]);
                }
                //二级分销员获得佣金
                if($distInteger->two_integer){
                    //$this->integralHold($distInteger->two_dist,$shop_id,$distInteger->task_code,$distInteger->two_integer/100,$goods_name,$mobile);
                    OrderService::integralHold([
                        "integral_task_id"  =>  $distInteger->task_code,
                        "uuid"              =>  $distInteger->two_dist,
                        "merchant_id"       =>  $shop_id,
                        "shop_id"           =>  $shop_id,
                        "reduce_integral"   =>  $distInteger->two_integer/100,
                        "user_phone"        =>  $mobile,
                        "type"              =>   "4",
                        "desc"              =>  "商家派发积分给分销员",
                        "status"            =>  "2"
                    ]);
                }
            }

        }catch (\Throwable $t){
            $OutParams->code = 400;
            $OutParams->error = $t->getMessage();
        }
    }

    public function getShopInfo($store_id){

        $shop        =  TarsHelper::servantFactory(ShopServant::class);
        $resultMsg   =  new \App\Tars\cservant\BB\Shop\ShopTcp\classes\resultMsg();
        $shopInfo    =  new ShopInfo();


        $shop->shopInfo($store_id,$resultMsg,$shopInfo);

        if($resultMsg->msg == '店铺不存在') throw new BadRequestHttpException('店铺不存在');

        return $shopInfo;
    }

    /**
     * 商家赠送积分
     * @param $order_info
     * @param $result
     * @return bool
     */
    public function givePoints($order_info,$result){
            //TODO 修改商家积分->待结算;
            $releaseShopBuy = new   InReleaseShopBuy();
            $out_params     = new   IntegralRes;

            $releaseShopBuy->shop_id        = $order_info->shop_id;
            $releaseShopBuy->type           = 2;
            $releaseShopBuy->mark           = 2;
            $releaseShopBuy->points         = $order_info->gift_points;
            $releaseShopBuy->order_code     = $order_info->ordersn;
            $releaseShopBuy->env_domain_id  = 0;

            //积分服务
            $integral = TarsHelper::servantFactory(IntegralTafServiceServant::class);
            $integral->releaseShopPointsBuy($releaseShopBuy, $out_params);

            if ($out_params->code == 400){
                $result->code = 400;$result->error = $out_params->error;
                return false;
            }

            return true;
    }

    /**
     * 记录分销数据
     * @param $order_info
     * @param $result
     * @return distInteger
     * @throws \Exception
     */
    public function recordDist($order_info,$result){
        $record_param = new RecordParam();

        //若是核销产品，则获取线上支付的金额
        if($order_info->sale_code){
            $record_param->pay_online = $order_info->pay_online;
        }

        $record_param->amount       =   $order_info->money;
        $record_param->tranId       =   $order_info->id;
        $record_param->order_sn     =   $order_info->ordersn;
        $record_param->rate         =   20;
        $record_param->code         =   $order_info->dist_code;
        $record_param->uuid         =   $order_info->uuid;
        $record_param->storeId      =   $order_info->shop_id;
        $record_param->domainId     =   $order_info->env_domain_id;

        $goodNum = OrderGoods::query()->where('order_id', $order_info['id'])->value('num');
        $record_param->count        =   $goodNum;

        $dist_performance = TarsHelper::servantFactory(PerformanceServiceServant::class);
        $common           = new CommonOutParam();
        $distInteger      = new distInteger();
        $dist_performance->record($record_param, $distInteger,$common);

        if ($common->code !== 200){
            Log::info('分销记录添加异常：订单号:'.$order_info['ordersn'].';错误信息'.$common->message);
            $result->code = 400;$result->error = $common->message;
            throw new BadRequestHttpException($common->message);
        }
        var_dump('一级积分',$distInteger->one_integer);
        var_dump('二级积分',$distInteger->two_integer);

        return $distInteger;
    }

    /**
     * 分销佣金获得
     * @param $uuid
     * @param $shop_id
     * @param $task_code
     * @param $integer
     * @param $title
     * @param $mobile
     */
    public function integralHold($uuid,$shop_id,$task_code,$integer,$title,$mobile){
        $integralServent = TarsHelper::servantFactory(IntegralServant::class);
        $outParam        = new outParam();
        $integralHoldIn  = new integralHoldIn();

        var_dump('iiiiiiiii');
        var_dump($uuid);
        var_dump($shop_id);
        var_dump($mobile);
        var_dump($title);
        var_dump($task_code);
        var_dump($integer);

        $integralHoldIn->uuid               =   $uuid;
        $integralHoldIn->shop_id            =   $shop_id;
        $integralHoldIn->title              =   $title;
        $integralHoldIn->merchant_id        =   '??????????';
        $integralHoldIn->integral_task_id   =   $task_code;
        $integralHoldIn->reduce_integral    =   $integer;
        $integralHoldIn->user_phone         =   $mobile;
        $integralHoldIn->status             =   1;

        $integralServent->integralHold($integralHoldIn,$outParam);

        var_dump('uuuuuuuuuuuuuuuu');
        var_dump($outParam->code);
        var_dump($outParam->message);
    }

    /**
     * 拼团系统订单状态修改
     * @param $order_sn
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doGroupOrder($order_sn){

        $client =   new Client();

        $url    =   config('tars.group_host').'/api/groupBuy/common/payOrderCallback';

        $data   =   ['order_sn' =>  $order_sn];
        var_dump($order_sn);
        var_dump('这里请求拼团');

        //请求过去就行了，不做任何回调处理
        $request = $client->request('get',$url,['query'  =>  $data]);

        $a = $request->getBody();
        var_dump('请求回调');
        var_dump(json_decode($a,true));

    }

    /**
     * 扣除商家积分
     * @param $uuid
     * @param $integral
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateIntegral($uuid,$integral){

        try{

            $client     =   new Client();

            $url    =   env('INTEGRAL_HOST').'/Laravel/integral/updateIntegral';

            $data   =   [
                'uuid'              =>      $uuid,
                'update_integral'   =>      $integral,
                'update_desc'       =>      '订单手续费扣除积分',
                'update_type'       =>      2,
                'source_from'       =>      'order',
                'sign'              =>      1,
            ];

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('post',$url,['json'  =>  $data]);

            $body       =   $request->getBody();
            $bodyStr    =   json_decode($body,true);

            var_dump($bodyStr);
        }catch (\Exception $e){
            var_dump($e->getMessage().':'.$e->getLine());
        }
    }


    /**
     * 订单列表
     * @param InSearch $InParams
     * @param OutOrderList $OrderList
     * @param resultMsg $result
     */
    public function OrderList(InSearch $InParams, OutOrderList &$OrderList, resultMsg &$result)
    {
        $rows           = $InParams->rows;
        $search         = $InParams->search;
        $uuid           =$InParams->uuid;
        $shop_id        = $InParams->shop_id;
        $start          = $InParams->start;
        $end            = $InParams->end;
        $env_domain_id  = $InParams->env_domain_id;
        $order_id       = $InParams->order_id;

        try{
            if (!$shop_id){
                $result->code = 400;$result->error='缺少店铺id';
                return;
            }
            $order              =   new Order();
            $order_list         =   $order->getShopOrderList($rows,$shop_id,'','','','','','',$start,$end)->toArray();
            $OrderList->total   =   $order_list['total'];
            $out_order_info     =   new OutOrderInfo();
            $goods_struct       =   new OrderGoodsStruct();

            foreach ($order_list['data'] as $k => $order){
                $out_order_info->id             =   $order['id'];
                $out_order_info->ordersn        =   $order['ordersn'];
                $out_order_info->recipient      =   $order['recipient'];
                $out_order_info->address        =   $order['address'];
                $out_order_info->phone          =   $order['phone'];
                $out_order_info->paid_at        =   $order['paid_at'];
                $out_order_info->status         =   $order['status'];
                $out_order_info->amount         =   $order['money'];
                $out_order_info->gift_points    =   $order['gift_points'];
                foreach ($order['order_goods'] as $goods){
                    $goods_struct->subject  =   $goods['goods_name'];
                    $goods_struct->attr     =   $goods['attr_name'];
                    $goods_struct->num      =   $goods['num'];
                    $goods_struct->thumb    =   $goods['thumb'];
                    $goods_struct->price    =   $goods['price'];
                    $out_order_info->goods->pushBack($goods_struct);
                }
                $OrderList->items->pushBack($out_order_info);
            }
        }catch (\Throwable $t){
            $result = new resultMsg();
            $result->code = 400;
            $result->error = $t->getMessage();
        }
    }

    /**
     * 订单详情
     * @param int $id
     * @param OutOrderInfo $OrderInfo
     * @param resultMsg $resultMsg
     */
    public function OrderInfo($id, OutOrderInfo &$OrderInfo, resultMsg &$resultMsg)
    {
        try{
            $goods_struct = new OrderGoodsStruct();
            $order = (new Order())->orderInfo($id);
            if (!$order) throw new InvalidResourceException('没有此订单信息');

            $order_info = $order->toArray();
            foreach ($order_info['order_goods'] as $k=>$v){
                $goods_struct->subject  =   $v['goods_name'];
                $goods_struct->attr     =   $v['attr_name'];
                $goods_struct->thumb    =   $v['thumb'];
                $goods_struct->num      =   $v['num'];
                $goods_struct->price    =   $v['price'];
                $OrderInfo->goods->pushBack($goods_struct);
            }
            $OrderInfo->id = $order_info['id'];
            $OrderInfo->ordersn     =   $order_info['ordersn'];
            $OrderInfo->recipient   =   $order_info['recipient'];
            $OrderInfo->address     =   $order_info['address'];
            $OrderInfo->phone       =   $order_info['phone'];
            $OrderInfo->paid_at     =   $order_info['paid_at'];
            $OrderInfo->status      =   $order_info['status'];
            $OrderInfo->amount      =   $order_info['money'];
            $OrderInfo->gift_points =   $order_info['gift_points'];
            $OrderInfo->deposit     =   $order_info['deposit'];
            $OrderInfo->shop_id     =   $order_info['shop_id'];
            return;
        }catch (\Throwable $t){
            $resultMsg->code = 400;
            $resultMsg->error = $t->getMessage();
            return;
        }
    }

    /**
     * 订单修改（虚拟核销多次支付订单）
     * @param InUpdateOrder $InUpdateOrder
     * @param resultMsg $OurParams
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateOrder(InUpdateOrder $InUpdateOrder, resultMsg &$OurParams)
    {
        var_dump('虚拟核销：');
        var_dump($InUpdateOrder->order_sn);
        try{
            if(!$InUpdateOrder->order_sn){
                $OurParams->code = '400';$OurParams->error = '订单号不能为空~';
                return;
            }

            //获取主订单号
            $order_sn = OrderSon::query()->select('id','order_sn','status')->where('order_son',$InUpdateOrder->order_sn)->where('status',0)->first();

            if(!$order_sn) return;

            $select =   ['id','uuid','business_id','recipient','phone','create_by_phone','store_mobile','shop_id','gift_points','ordersn','hand_rate',
                        'hand_cost','pay_online','pay_offline','surplus_money','status'];
            $order_info = Order::query()->select($select)->where('ordersn',$order_sn->order_sn)->first();

            if(!$order_info){
                $OurParams->code = '400';$OurParams->error = '不存在该订单';
                return;
            }

            $amount         =   $InUpdateOrder->amount;             //支付金额
            $surplus_money  =   $order_info->surplus_money * 100;   //未支付金额
            $pay_type       =   $InUpdateOrder->status;             //支付方式：1微信支付，2莞银通支付，3易票联支付

            //若未支付金额为0，则不作处理
            if($surplus_money == 0){
                $OurParams->error = '该核销订单已经支付完毕';
                return;
            }
            var_dump('手续费比例 ： '.$order_info->hand_rate);
            var_dump('支付金额 ： '.$InUpdateOrder->amount);
            //计算抽佣积分
            $integral    =   $order_info->hand_rate * $InUpdateOrder->amount * 20 / 10000;
            var_dump('抽佣积分 ： '.$integral);

            DB::beginTransaction();
            //订单核销 : 支付金额大于或等于未支付金额
            if ($amount >= $surplus_money){

                //由于支付完成，金额改为0
                $surplus_money = 0.00;
                //记录核销信息
                if(!$this->doHirePur($order_info,$amount,$surplus_money,$integral,1,$pay_type)){
                    $OurParams->code = '400';$OurParams->error = '核销记录插入错误~';
                    DB::rollBack();return;
                }

                //操作记录
                $make = "核销订单结束";
                $set = OrderService::addOrderRecord($order_info->id,$order_info->recipient,$order_info->phone,3,$make);
                if(!$set){
                    $OurParams->code = '400';$OurParams->error = '操作记录插入错误~';
                    DB::rollBack();return;
                }

                $order_info->surplus_money  = $surplus_money;       //未支付金额已付完
                $order_info->paid           = 1;                    //已支付
                $order_info->status         = 4;                    //已核销
                $order_info->paid_at        = date('Y-m-d H:i:s');  //已核销
                $order_info->updated_at     = date('Y-m-d H:i:s');  //已核销
                $order_info->save();

                //核销完毕，通知支付系统
                OrderService::unifiedShare($order_sn->order_sn);

                //执行消息推送
                OrderService::doNoticeHttpBySale($order_info);

            }else{
                //计算未支付金额
                $surplus_money = (($order_info->surplus_money * 100) - $amount) /100;

                //记录核销信息
                if(!$this->doHirePur($order_info,$amount,$surplus_money,$integral,0,$pay_type)){
                    $OurParams->code = '400';$OurParams->error = '核销记录插入错误~';
                    DB::rollBack();return;

                }

                //操作记录
                $make   =   "核销订单支付";
                $set    =   OrderService::addOrderRecord($order_info->id,$order_info->recipient,$order_info->phone,4,$make);
                if(!$set){
                    $OurParams->code = '400';$OurParams->error = '操作记录插入错误~';
                    DB::rollBack();return;
                }

                //修改未支付金额
                $order_info->surplus_money  =   $surplus_money;     //未支付金额
                $order_info->status         =   5;                  //核销中
                $order_info->save();

            }

            //扣除手续费(扣除商家积分)
            if($order_info->hand_cost > 0)   $this->updateIntegral($order_info->business_id,$integral);

            $order_sn->status  = 1;
            $order_sn->save();

            DB::commit();
            $OurParams->error = '数据操作成功';

        }catch (\Throwable $t){
            $OurParams->code = '400';
            $OurParams->error = $t->getMessage();
            DB::rollBack();
        }
    }

    /**
     * 核销信息记录
     * @param $order
     * @param $pay_money
     * @param $surplus_money
     * @param $status
     * @param $pay_type
     * @return bool
     */
    public function doHirePur($order,$pay_money,$surplus_money,$integral,$status,$pay_type){

        $newTime = date('Y-m-d H:i:s');

        $data = [
            'order_id'        =>  $order->id,
            'order_sn'        =>  $order->ordersn,
            'pay_money'       =>  $pay_money / 100,
            'status'          =>  $status,
            'pay_type'        =>  $pay_type,
            'surplus_money'   =>  $surplus_money,
            'hand_cost'       =>  $integral,
            'pay_at'          =>  $newTime,
            'created_at'      =>  $newTime,
            'updated_at'      =>  $newTime
        ];

        if(!OrderHirePur::query()->insert($data)) return false;

        return true;
    }


    /**
     * 积分发放
     * @param $order_info
     */
    public function writeOffGivePoints($order_info){
        $integral_servant = TarsHelper::servantFactory(IntegralTafServiceServant::class);
        $write_give             = new InWriteOffGive();
        $resultMsg              = new IntegralRes();
        $write_give->uuid       = $order_info['uuid'];
        $write_give->shop_id    = $order_info['shop_id'];
        $write_give->points     = $order_info['gift_points'];
        $write_give->order_code = $order_info['ordersn'];
        $integral_servant->writeOffGivePoints($write_give, $resultMsg);
    }

    /**
     * 分销
     * @param $order_info
     */
    public function updateRecord($order_info){
        $performance_servant = TarsHelper::servantFactory(PerformanceServiceServant::class);
        $common                     =   new CommonOutParam;
        $update_param               =   new UpdateParam;
        $update_param->tranId       =   $order_info['id'];
        $update_param->status       =   3;
        $update_param->businessId   =   $order_info['shop_id'];

        $performance_servant->updateRecord($update_param, $common);
    }
    /**
     * 获取用户消费总金额
     * @param string $uuid
     * @param OutConsumption $detail
     * @param resultMsg $result
     */
    /*public function userConsumption($uuid,$shop_id,OutConsumption &$detail,resultMsg &$result)
    {
        //暂时先统计付款的金额（不考虑后续退款、退货）
        $query = Order::query()->where('uuid',$uuid)->whereIn('status',[1,2,3,4]);
        if ($shop_id) {
            $query->where('shop_id',$shop_id);
        }
        $amount = $query->sum('money');
        $total = $query->count();
        $detail->total = $total;
        $detail->amount = $amount*100;
    }*/

    /**获取用户消费总金额
     * @param string $uuid
     * @param int $shop_id
     * @param OutConsumption $cons
     * @param resultMsg $result
     */
    public function userConstion($uuid, $shop_id, outConsumption &$cons, resultMsg &$result)
    {
        // TODO: Implement userConstion() method.
        //暂时先统计付款的金额（不考虑后续退款、退货）
        $query = Order::query()->where('uuid',$uuid)->whereIn('status',[1,2,3,4]);
        if ($shop_id) {
            $query->where('shop_id',$shop_id);
        }
        $cons->total = $query->count();
        $cons->amount = $query->sum('money')*100;
    }

    /**
     * 计算店铺可用的总金额，(含待结算的金额)
     * @param int $store_id
     * @param resultMsg $result
     * @param outMoney $Moneys
     */
    public function totalMoney($store_id, resultMsg &$result, outMoney &$Moneys)
    {
        // TODO: Implement totalMoney() method.
        $validator = Validator::make([
            'store_id'  =>  $store_id
        ],[
            'store_id'  =>  'bail|required|int',
        ]);
        if($errors = $validator->errors()->first()){
            $result->code = 400;$result->error=$errors;
            return;
        }
        //获取订单已支付未收货，已核销的结算的金额,手续费
        $data = $this->getMoney($store_id,1,[-4,1,2]);
        //待结算金额
        $_money = $data['totalmoney'];

        //正常订单，核销定金的手续费
        $handMoney = $data['handMoney'];
        //线下核销的交易手续费
        //$saleMoney = $this->getMoney($store_id,1,[4])['saleMoney'];
        //获取店铺商户号
        $shopServant = TarsHelper::servantFactory(ShopServant::class);


        $resultMsg          = new  \App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\resultMsg();
        $outMerchantInfo    = new  \App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\outMerchantInfo();
        //开始调度获取店铺信息
        $shopServant->getMerchantInfo($store_id,$resultMsg,$outMerchantInfo);

        if($resultMsg->code !== 200){
            $result->code = 400;$result->error=$resultMsg->msg;
            return;
        }
        //获取商户号
        $merchant_number = $outMerchantInfo->merchant_number;
        //通过商户号获取店铺原有的余额
        $payService = TarsHelper::servantFactory(PayServiceServant::class);
        $Status = new Status();
        $OutMechantOverage = new OutMechantOverage();

        var_dump('店铺商户号：'.$merchant_number);

        //开始调度
        $payService->mechantOverage($merchant_number,$OutMechantOverage,$Status);
        if($Status->err != 0){
            $result->code = 400;$result->error=$resultMsg->msg;
            return;
        }
        //获取商户余额
        $balance = $OutMechantOverage->balance;
        var_dump('账户余额 ： '.number_format($OutMechantOverage->balance/100,2,'.',''));
        var_dump('冻结金额 ： '.number_format($OutMechantOverage->frozenBalance/100,2,'.',''));

        //计算展示的可用店铺余额
        $balance = $balance - $_money +  $handMoney;
        $Moneys->avaMoney = number_format($balance/100,2,'.','');
        var_dump('可用店铺余额 : '.$Moneys->avaMoney);
        //待结算金额
        $diffMoney = $_money - $handMoney;
        $Moneys->stayMoney = number_format($diffMoney/100,2,'.','');
        var_dump('待结算金额 : '.$Moneys->stayMoney);
        //不可用余额
        $Moneys->notMoney = 0.00;

        $result->code = 200;$result->error=$resultMsg->msg;
        return;
    }

    /**
     * 计算金额
     * @param $store_id
     * @param $paid
     * @param array $status
     * @return array
     */
    public function getMoney($store_id,$paid,$status = []){
        $totalmoney = 0;    //计算支付订单的总金额
        $handMoney = 0;     //每比订单的手续费
        $saleMoney = 0;     //核销订单的线下交易手续费

        Order::query()->where('shop_id',$store_id)->whereIn('status',$status)->where('paid',$paid)->get(['money','pay_online','status','hand_cost','sale_cost'])
            ->each(function ($item) use(&$totalmoney,&$handMoney,&$saleMoney) {
                if(in_array($item->status,[1,2])){
                    $totalmoney  +=  $item->money * 100;
                }else if($item->status == -4){
                    $totalmoney  +=  $item->pay_online * 100;
                }

                $handMoney   +=  $item->hand_cost * 100;
                $saleMoney   +=  $item->sale_cost * 100;
            });
        return ['totalmoney'=>$totalmoney,'handMoney'=>$handMoney,'saleMoney'=>$saleMoney];
    }



    /**
     * 验证订单的合法性
     * @param string $orderSn
     * @param resultMsg $result
     */
    public function checkOrder($orderSn, resultMsg &$result)
    {
        // TODO: Implement checkOrder() method.
        if(!$orderSn){
            $result->code = 400;$result->error = '缺少订单号！';
            return;
        }
        $has = Order::query()->where('ordersn',$orderSn)->whereIn('status',[-4,0])->first('id');
        $shopName = OrderGoods::query()->where('order_id',$has->id)->value('goods_name');
        if(!$has){
            $result->code = 400;$result->error = '此订单不是待支付订单';
            return;
        }
        $result->code = 200;$result->error = $shopName;
    }

    /**
     * 设置当前店铺的未结算的订单
     * 注释：此处，可以直接那店铺id到分销系统匹配未结算的分销订单
     * 由于之前需求原因，已经做好，不在做修改
     * @param int $stord_id
     * @param int $points
     * @param int $domainid
     * @param resultMsg $result
     */
    public function setNotSett($stord_id,$points,$domainid,resultMsg &$result)
    {
        var_dump('haha');
        var_dump($stord_id);
        var_dump($points);
        // TODO: Implement setNotSett() method.
        if(!$stord_id){
            var_dump('1111');
            $result->code = 400;$result->error = '缺少店铺id！';
            return;
        }
        //积分服务
        $integral = TarsHelper::servantFactory(IntegralTafServiceServant::class);
        //获取商家当前积分
        if(!$point = $this->getShopPoint($stord_id,$integral,$domainid,$result)) return;


        if($points <= 0){
            $result->code = 200;$result->error = '当前充值的积分小于0，不给予积分发放';
            return;
        }

        var_dump('fuck  comming');

        //获取店铺分销且未结算的订单
        $hasOrder = Order::query()->where('shop_id',$stord_id)->whereNotNull('dist_code')->where('paid',1)->where('check_sett',0)
            ->get(['id','uuid','shop_id','ordersn','check_sett','dist_code']);

        //var_dump($has->toArray());
        //分销服务
        $performance_servant = TarsHelper::servantFactory(PerformanceServiceServant::class);
        $common = new CommonOutParam;
        var_dump($hasOrder->toArray());
        var_dump('2222');
        //若存在未结算的分销订单，则循环结算
        if(count($hasOrder)){
            $myPoints = $points;
            foreach ($hasOrder as $item){
                var_dump('3333');
                var_dump('id:'.$item->id);

                //设置ok值为0，若ok值不为0时，则表示积分发放未完成
                $ok = 0;

                //获取当前订单的待发放佣金积分数据,无则跳过
                if(!$amounts = $this->getAmount($item->id,$result,$performance_servant,$common)) continue;
                var_dump('haha');
                //循环获取的分销订单数据(有自己或者上级)
                foreach ($amounts as $amount){
                    var_dump($myPoints);
                    var_dump($amount['point']);
                    //当前商家刚充值的积分不足派送的佣金积分,则跳过当先数据向下寻找
                    if($myPoints < $amount['point']){
                        $ok = 1;    //积分未发放完成
                        continue;
                    }

                    //积分交易
                    if(!$this->integralTransaction($amount['uuid'],$item->shop_id,$amount['point'],$integral,$result)) return;
                    var_dump('xxxxxxx');

                    //修改分销积分已经结算状态
                    if(!$this->editStatus($amount['id'],$result,$performance_servant,$common)) return;
                    $myPoints = $myPoints - $amount['point'];
                }
                //若ok值不为0，则表示积分结算状态未完成
                if($ok){
                    $ok = 0;
                    continue;
                }

                var_dump('66666666666');
                //修改订单积分已结算状态
                $item->check_sett = 1;
                var_dump('xixi');
                var_dump($item->save());
            }
        }

        $result->code = 200;
        $result->error = '积分自动发放完成~';
    }

    /**
     * 分销订单的积分结算
     * @param int $orderId
     * @param resultMsg $result
     */
    public function checkSett($orderId, resultMsg &$result)
    {
        // TODO: Implement checkSett() method.
        try{
            if(!$orderId){
                $result->code = 400;$result->error = '缺少订单id！';
                return;
            }
            //获取对应的未结算的订单信息
            $has = Order::query()->where('id',$orderId)->where('paid',1)->where('check_sett',0)->first(['id','check_sett']);
            if(!$has){
                $result->code = 400;$result->error = '未找到对应的未结算分销订单！';
                return;
            }
            //设置成已经积分结算
            $has->check_sett = 1;
            $has->save();
            $result->code = 200;$result->error = '修改成功！';
        }catch (\Throwable $e){
            $result->code = 400;
            $result->error = $e->getMessage();
        }

    }

    /**
     * 获取当前商家的积分
     * @param $shop_id
     * @param $integral
     * @param $result
     * @return bool|float|int
     */
    public function getShopPoint($shop_id,$integral,$domainid,$result){
        var_dump($shop_id);
        $inputById              =   new inputById();
        $inputById->shop_id     =   $shop_id;
        $inputById->domainId    =   $domainid;

        $myPoints  = new myPoints();
        $outSettle =   new \App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\resultMsg();

        $integral->integralBalance($inputById,$myPoints,$outSettle);
        if($outSettle->code == 400) return false;

        return $myPoints->points;
    }



    /**
     * @param $uuid
     * @param $points
     * @param $shop_id
     * @param $integral_servant
     * @param $result
     * @return bool
     */
    public function addPoints($uuid,$points,$shop_id,$integral_servant,$result){
        $inparams = new InGiveUserBuy();
        $res = new \App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\resultMsg();
        $inparams->points = $points;
        $inparams->shop_id = $shop_id;
        $inparams->uuid = $uuid;
        $integral_servant->giveUserPointsBuy($inparams, $res);

        if ($res->code == 400) {
            $result->code = 400;$result->error = $res->error;
            return false;
        }
        return true;
    }

    /**
     * @param $tran_id
     * @param $result
     * @param $performance_servant
     * @param $common
     * @return bool
     */
    public function editStatus($tran_id,$result,$performance_servant,$common){
        var_dump('zzzz');
        $performance_servant->editStatus($tran_id,$common);
        if($common->code == 400){
            $result->code = 400;$result->error = $common->message;
            return false;
        }
        return true;
    }

    public function integralTransaction($uuid,$store_id,$points,$integral,$outParam){
        var_dump('nnnnnnnnnnn');
        var_dump($uuid);
        var_dump($store_id);
        $inSettle = new InTransaction();
        $inSettle->uuid = $uuid;
        $inSettle->shop_id = $store_id; //扣除
        $inSettle->points = $points;
        $inSettle->type_mark = 'dist';
        $outSettle = new \App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\resultMsg();
        $integral->integralTransaction($inSettle, $outSettle);
        if($outSettle->code == 400){
            //$outParam->code = 400;$outParam->message = '分销记录更新失败';
            return false;
        }
        return true;
    }

    /**
     * @param $id
     * @param $result
     * @param $performance_servant
     * @param $common
     * @return amounts|bool
     */
    public function getAmount($id,$result,$performance_servant,$common){
        $amount = new amounts();
        $performance_servant->getAmount($id,$common,$amount);
        var_dump($common->message);
        if($common->code == 400){
            //$result->code = 400;$result->error = $common->message;
            return false;
        }
        var_dump($amount);
        return $amount;
    }

    /**
     * 获取订单数，销售量
     * @param int $stord_id
     * @param int $good_id
     * @param resultMsg $result
     * @param orderCounts $orderCount
     */
    public function getOrderCount($stord_id,$good_id,resultMsg &$result, orderCounts &$orderCount)
    {
        try{
            if(!$stord_id){
                $result->code = 400;$result->error = '缺少店铺id';
                return;
            }

            //$domainId = 1;

            // TODO: Implement getOrderCount() method.
            //获取订单数（已支付/待核销）
            //$orderCount->orderCount = Order::query()->where('shop_id',$stord_id)->where('env_domain_id',$domainId)->whereIn('status',[-4,1,2,3,4])->count();
            $orderCount->orderCount = Order::query()->where('shop_id',$stord_id)->where(function ($query){
                $query->whereRaw('order_type in (1, 2, 3, 4, 6) and status in (-4,1,2,3,4)')
                    ->orWhereRaw('order_type = 5 and status in (-4,4) and group_success = 1');
            })->count();

            //店铺订单总销量
            //$orderCount->sellCount  = Order::withTrashed()->from('orders as o')->where('o.shop_id',$stord_id)->whereIn('o.status',[-4,1,2,3,4])
            $orderCount->sellCount  = Order::withTrashed()->from('orders as o')->where('o.shop_id',$stord_id)->where(function ($query){
                $query->whereRaw('order_type in (1, 2, 3, 4, 6) and status in (-4,1,2,3,4)')
                    ->orWhereRaw('order_type = 5 and status in (-4,4) and group_success = 1');
                })->leftJoin('orders_goods as g','o.id','=','g.order_id')->sum('g.num');


            //店铺商品订单总销量
            //$orderCount->goodsCount = Order::withTrashed()->from('orders as o')->where('o.shop_id',$stord_id)->whereIn('o.status',[-4,1,2,3,4])
            $orderCount->goodsCount = Order::withTrashed()->from('orders as o')->where('o.shop_id',$stord_id)->where(function ($query){
                $query->whereRaw('order_type in (1, 2, 3, 4, 6) and status in (-4,1,2,3,4)')
                    ->orWhereRaw('order_type = 5 and status in (-4,4) and group_success = 1');
                })->leftJoin('orders_goods as g','o.id','=','g.order_id')->where('g.goods_id',$good_id)->sum('g.num');

        }catch (\Exception $e){
            throw new \Exception($e->getMessage().':'.$e->getLine());
        }
    }


}
