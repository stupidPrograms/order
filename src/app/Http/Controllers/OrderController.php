<?php

namespace App\Http\Controllers;

use App\Data\OrderData;
use App\Data\ShopData;
use App\Models\OrderSon;
use App\Models\OrderCoupon;
use App\Models\OrderHirePur;
use App\Models\OrderRecord;
use App\Models\Order;
use App\Services\OrderService;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\resultMsg;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\InUpdateOrder;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Tars\cservant\BB\UserService\User\UserServant;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\OrderServant;
use App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\InNotifyData;

use App\Tars\impl\TarsHelper;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderController extends BaseController
{


    public function testOrder(){

        $OrderServant   =   TarsHelper::servantFactory(OrderServant::class);
        $outParams      =   new \App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\resultMsg();
        $orderCounts    =   new \App\Tars\cservant\OrderSystem\OrderServer\OrderObj\classes\orderCounts();

        $store_id = 17;
        $domainId = 1;
        $OrderServant->getOrderCount($store_id,$outParams,$orderCounts);


    }

    /**
     * 用户所有订单列表(商家用户/普通用户)
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $uuid       =   $request->user()->uuid;
        $page       =   $request->input('page');
        $rows       =   $request->input('rows');
        $status     =   $request->input('status');
        $is_store   =   $request->input('is_store',0);
        //此处处理因服务重启而丢失处理超时未支付的订单
        OrderService::checkOffOrder($uuid);

        //7天后为收货订单修改为已收货
        OrderService::confirmReceipt($uuid);

        $data = Order::getUserOrder($rows,$is_store,$uuid,$status, null,$page);
        return $this->success($data);
    }

    /**
     * 用户单个店铺订单列表(商家用户/普通用户)
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function shopOrder(Request $request, $id)
    {
        try{
            $uuid           =   $request->user()->uuid;
            $mobile         =   $request->user()->mobile;
            $user_uuid      =   $request->input('user_uuid');
            $user_mobile    =   $request->input('user_mobile');
            $page           =   $request->input('page',1);
            $rows           =   $request->input('rows',10);
            $status         =   $request->input('status');
            $is_store       =   $request->input('is_store',0);

            if($id == 'null') return $this->failed('缺少店铺id');

            //若是商家，则uuid赋值为店铺id
            if($is_store && $is_store == 1) $uuid       =   $id;

            //此处用于帮部落，商家查看用户所有的订单数据
            if($user_uuid && $user_mobile){
                $uuid       =   $user_uuid;
                $mobile     =   $user_mobile;
            }

            //此处处理因服务重启而丢失处理超时未支付的订单
            OrderService::checkOffOrder($uuid);

            //7天后为收货订单修改为已收货
            OrderService::confirmReceipt($uuid);

            //绑定第一次注册该平台，用户之前已有的虚拟订单
            OrderService::checkSaleOrder($uuid,$mobile);

            //取得用户指定店铺id的订单列表
            $_data = Order::getUserShopOrder($uuid,$is_store,$id, $status, $page, $rows);

            $data           =  $_data->items();
            $current_page   =   $_data->currentPage();
            $total          =   $_data->total();

            return $this->success(compact('data','current_page','total'));

        }catch (\Exception $e){
            var_export($e->getMessage());
            return $this->failed($e->getMessage());
        }
    }


    /**
     * 创建正常商品订单
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try{
            $validator      =   Validator::make($request->all(),[
                'num'        =>  'bail|required|min:1',
                'domain_id'  =>  'bail|required|in:1,2',
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }
            $openid         =   '';
            $user           =   $request->user();
            $uuid           =   $user->uuid;
            $goods_num      =   $request->input('num');
            $good_id        =   $request->input('goods_id',0);
            $goods_id       =   $request->input('good_id',0);
            $sku_id         =   $request->input('sku_id',0);
            $coupon_id      =   $request->input('coupon_id');            //优惠券id
            $dist_code      =   $request->input('dist_code');
            $domain_id      =   $request->input('domain_id',1);
            $mobile         =   $request->input('mobile');
            $address_id     =   $request->input('address_id',0);
            $product_types  =   $request->input('product_types',0);


            if(!$good_id)      $good_id =    $goods_id;

            $info = [
                'recipient'  => $user->mobile,
                'phone'      => $user->mobile,
            ];

            $order_type     =   2;
            if($address_id) $order_type =   1;

            $orderObj = OrderService::createOrder($info,$uuid,$openid,$good_id,$goods_num,$sku_id,$dist_code,$address_id,$product_types,$coupon_id,$domain_id,$mobile,$order_type);

            return $this->success([
                'order_id'      => $orderObj->getOrderModels()->id,          //订单系统的order_id
                'pay_ordersn'   => $orderObj->getOrderModels()->ordersn,     //支付系统的order_id
                'pay_online'    => $orderObj->getOrderModels()->pay_online,  //支付金额
                'over_time'     => $orderObj->getExpiredTimeStamp(),        //过期时间
            ]);
        }catch (\Exception $e){
            return  $this->failed($e->getMessage());
        }
    }

    /**
     * 创建秒杀订单
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function seckOrder(Request $request){
        try{
            $user           =   $request->user();
            $uuid           =   $user->uuid;

            $sku_id         =   $request->post('sku_id',0);
            $good_id        =   $request->post('good_id',0);
            $pay_online     =   $request->post('pay_online',0);         //支付金额
            $channel_code   =   $request->post('channel_code',null);    //秒杀任务号
            $poster_code    =   $request->post('poster_code',null);     //海报号
            $store_mobile   =   $request->post('store_mobile');         //联系商家电话

            $info = [
                'recipient'  => $user->mobile,
                'phone'      => $user->mobile,
            ];
            list($msec0, $sec0) = explode(' ', microtime());
            var_dump([$msec0,$sec0]);


            var_dump('秒杀加载');

            var_dump($sku_id);
            var_dump($good_id);

            $orderObj = OrderService::createSeckOrder($info,$uuid,$good_id,$sku_id,$pay_online,$channel_code,$poster_code,$store_mobile);

            list($msec1, $sec1) = explode(' ', microtime());
            var_dump('--------------------');
            var_dump([$msec1, $sec1]);
            return $this->success([
                'order_id'      => $orderObj->getOrderModels()->id,          //订单系统的order_id
                'pay_ordersn'   => $orderObj->getOrderModels()->ordersn,     //支付系统的order_id
                'pay_online'    => $orderObj->getOrderModels()->pay_online,  //支付金额
                'sale_code'     => $orderObj->getOrderModels()->sale_code,   //核销码
            ]);
        }catch (\Exception $e){
            return  $this->failed($e->getMessage());
        }
    }

    /**
     * 创建拼团订单
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function groupOrder(Request $request){

        try{
            $user           =   $request->user();
            $uuid           =   $user->uuid;

            $code           =   $request->post('code',null);
            $sku_id         =   $request->post('sku_id',0);
            $pay_online     =   $request->post('pay_online',0); //支付金额
            $good_id        =   $request->post('good_id',0);
            $store_mobile   =   $request->post('store_mobile');
            var_dump('sssssssddd');
            var_dump($store_mobile);

            $info = [
                'recipient'  => $user->mobile,
                'phone'      => $user->mobile,
            ];

            //创建拼团订单
            $orderObj = OrderService::createGroupOrder($info,$uuid,$good_id,$sku_id,$pay_online,$code,$store_mobile);

            return $this->success([
                'order_id'      => $orderObj->getOrderModels()->id,          //订单系统的order_id
                'pay_ordersn'   => $orderObj->getOrderModels()->ordersn,     //支付系统的order_id
                'pay_online'    => $orderObj->getOrderModels()->pay_online,  //支付金额
                'sale_code'     => $orderObj->getOrderModels()->sale_code,    //核销码
            ]);
        }catch (\Exception $e){
            return  $this->failed($e->getMessage());
        }
    }

    /**
     * 创建虚拟商品订单
     * @param Request $request
     * @return mixed
     */
    public function create_sale(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'price'     =>  'bail|required|numeric',
                'mobile'    =>  'bail|required',
                'shop_id'   =>  'bail|required|integer',
                'domain_id' =>  'bail|required|numeric|in:1,2',
            ],[
                'price.required'    =>  '请输入商品总价',
                'mobile.required'   =>  '手机号必填'
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $price      =   $request->post('price');
            $mobile     =   $request->post('mobile');
            $shop_id    =   $request->post('shop_id');
            $domain_id  =   $request->post('domain_id');
            $coupon_id  =   $request->post('coupon_id',0);

            //判断手机号是否存在
            $has = OrderData::getUserInfoByMobile($mobile);
            var_dump($coupon_id);

            $uuid = $has->uuid;
            //创建人的手机号
            $create_by_phone = $mobile;

            //若手机号不存在，置空
            if(!$uuid)    $mobile = '';
            var_dump('aaaa');
            var_dump($uuid);
            //因为创建的是虚拟订单，不考虑正常订单的库存等流程，直接简单的数据入库
            $orderObj = OrderService::createSaleOrder($uuid,$price,$shop_id,$domain_id,$coupon_id,$mobile,$create_by_phone);

            return $this->success([
                'mobile'        => $mobile,
                'start'         => $orderObj->getOrderModels()->status,
                'order_id'      => $orderObj->getOrderModels()->id,           //订单系统的order_id
                'pay_ordersn'   => $orderObj->getOrderModels()->ordersn,     //支付系统的order_id
                'pay_online'    => $orderObj->getOrderModels()->pay_online,   //支付金额
                'pay_money'     => $orderObj->getOrderModels()->money,        //支付金额
                'sale_code'     => $orderObj->getOrderModels()->sale_code,    //核销随机码
            ]);
        }catch (\Exception $e){
            return $this->failed($e->getMessage().':'.$e->getLine());
        }
    }



    /**
     * 生成子订单号
     * @param Request $request
     * @return mixed
     */
    public function creatSon(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'order_sn'   =>  'bail|required|string',    //主订单号
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $order_son  =   date('YmdHis').rand(100000, 999999);

            $data = [
              'order_sn'    =>  $request->get('order_sn'),
              'order_son'   =>  $order_son,
            ];

            $set = OrderSon::query()->insert($data);

            if(!$set)   return $this->failed('数据插入失败');

            return $this->success(compact('order_son'));
        }catch (\Exception $e){
            return $this->failed($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 核销订单修改优惠券
     * @param Request $request
     * @return mixed
     */
    public function upSaleCoupon(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'order_sn'   =>  'bail|required|string',
                'coupon_id'  =>  'bail|required|integer'
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $order_sn   =   $request->input('order_sn');
            $coupon_id  =   $request->input('coupon_id');

            //核销订单修改优惠券
            $coupon_money = OrderService::updateSaleByCoupon($order_sn,$coupon_id);

            return $this->success($coupon_money);

        }catch (\Exception $e){
            return $this->failed($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 修改核销订单金额
     * @param Request $request
     * @return mixed|string
     */
    public function upOrderPirce(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'order_sn'  =>  'bail|required|string',
                'price'     =>  'bail|required|numeric',
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $order_sn   =   $request->input('order_sn');
            $price      =   $request->input('price');

            $good_name  =   $request->input('goods_name','虚拟商品');
            $recipient  =   $request->input('recipient','N/A');
            $address    =   $request->input('address','N/A');

            //修改核销订单金额
            OrderService::upOrderPirce($order_sn,$good_name,$price,$recipient,$address);

            return $this->success(number_format($price,2,'.',''));
        }catch (\Exception $e){
            return $this->failed($e->getMessage());
        }
    }

    /**
     * 结束核销订单
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function endSaleOrder(Request $request){
        try{

            $store_id   =   $request->input('store_id',0);
            $sale_code  =   $request->input('sale_code',null);
            $order_sn   =   $request->input('order_sn',null);

            if(empty($sale_code) && empty($order_sn))   return  $this->failed('订单号或者核销码不能为空');

            //核销订单结束
            $order      =   OrderService::endSaleOrder($store_id,$order_sn,$sale_code);

            //秒杀核销回调
            if($order->order_type == 4) $this->dosetOrder($order->ordersn);

            //拼团核销回调
            if($order->order_type == 5) $this->saleCallback($order->ordersn);

            //通知支付系统(若没经过支付的订单直接核销，则支付系统不存在核销订单记录)
            OrderService::unifiedShare($order->ordersn);

            //执行消息推送
            OrderService::doNoticeHttpBySale($order);

            return $this->success('核销成功');
        }catch (\Exception $e){
            return  $this->failed($e->getMessage());
        }
    }

    /**
     * 秒杀系统核销状态修改
     * @param $order_sn
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function dosetOrder($order_sn){
    //public function dosetOrder(Request $request){
        try{
            //$order_sn   =   $request->get('order_sn');

            $client     =   new Client();

            $url        =   config('tars.skill_host').'/Laravel/route/admin/verification/set';
            var_dump($url);

            $data       =   ['order_no' =>  $order_sn];

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('post',$url,['query'  =>  $data]);

            $body       =   $request->getBody();
            $bodyStr    = (string)$body;

            return  $this->success($bodyStr);
        }catch (\Exception $e){
            return $this->failed($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * @param $order_sn
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function saleCallback($order_sn){
    //public function saleCallback(Request $request){
        try{
            //$order_sn   =   $request->get('order_sn');
            $client     =   new Client();

            $url    =   config('tars.group_host').'/api/groupBuy/common/verifyOrderCallback';

            $data   =   ['order_sn' =>  $order_sn];

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('get',$url,['query'  =>  $data]);

            $body       =   $request->getBody();
            $bodyStr    = (string)$body;

            return  $this->success($bodyStr);
        }catch (\Exception $e){
            return $this->failed($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 查询单个订单详情
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show($id,Request $request)
    {
        $order = Order::withTrashed()->where('id',$id)->with(['orderGoods'])->with([
            'orderCoupon' => function($query){
                $query->select('order_id','coupon_name','coupon_type','amount','reduction_money');
            }])->first();

        if(!$order){
            return $this->failed('暂无该订单数据');
        }

        $shopObj   =  new ShopData($order->shop_id);
        $shopInfo  =  $shopObj->getShopInfo();

        $order->shop_mobile =   $shopInfo->mobile;

        //核销已支付金额
        $order->PaidMoney   =   OrderHirePur::query()->where('order_id',$order->id)->sum('pay_money');;

        //核销支付记录
        $order->saleInfo    =   OrderHirePur::getSaleInfo($order->id);

        //若是秒杀订单，则获取提货开始和结束时间
        if($order->order_type == 4){
            var_dump('鸡儿');
            $a      = OrderService::getPickTIme($order->ordersn);
            $time   =   $a['data'];

            if($time){
                $order->statr_time  =   $time[0];
                $order->end_time    =   $time[1];
            }

        }

        return $this->success($order);
    }

    /**
     * 查询订单支付状态
     * @param Request $request
     * @return mixed
     */
    public function getOrderPayType(Request $request){
        try{
            $order_sn   =   $request->get('order_sn');

            if(!$order_sn)   return  $this->failed('缺少订单号');

            $order      =   Order::query()->where('ordersn',$order_sn)->first(['paid','status']);

            if(!$order) return  $this->failed('暂无该订单数据');

            return  $this->success($order);

        }catch (\Exception $e){
            Log::debug($e->getMessage().', line:'.$e->getLine());
            return $this->failed('意外错误');
        }
    }

    /**
     * 删除订单
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function destroy($id,Request $request)
    {

        $validator = Validator::make($request->all(),[
            'store_id'      =>  'bail|integer',
        ]);

        if($error = $validator->errors()->first())  return $this->failed($error);

        $uuid       =   $request->user()->uuid;

        $store_id       =   $request->input('store_id',0);

        //交易关闭后才能删除
        DB::beginTransaction();

        $orderModel  = Order::query()->where('id', $id)->where('status', -2);

        if($store_id){$orderModel->where('shop_id', $store_id);}
        else{$orderModel->where('uuid', $uuid);}

        $order = $orderModel->first(['recipient','phone']);

        if(!$order) return $this->failed('暂无该数据');

        $res    = $orderModel->delete();

        $datatime = date('Y-m-d H:i:s');

        //记录操作信息
        $data = [
            'order_id'      =>  $id,
            'operator'      =>  $order->recipient,
            'mobile'        =>  $order->phone,
            'record_type'   =>  4,
            'comment'       =>  '用户删除订单',
            'mark'          =>  '用户删除订单',
            'created_at'    =>  $datatime,
            'updated_at'    =>  $datatime,
        ];

        if(!OrderRecord::query()->insert($data)){
            DB::rollBack();
            return $this->failed('订单取消失败');
        }

        if (!$res){
            DB::rollBack();
            return $this->failed('删除订单出错');
        }

        DB::commit();
        return $this->success('订单已删除');
    }

    /**
     * 取消订单
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function cancelOrder(int $id, Request $request)
    {
        $order_id = $id;

        if(!isset($order_id))  return $this->failed('缺少选中的订单id');

        $remark     =   $request->input('remark', '');
        $uuid       =   $request->user()->uuid;


        $order = Order::query()->where('id', $order_id)->where('uuid', $uuid)->where('status',0)->first([
            'id','ordersn','recipient','phone','status','order_type'
        ]);

        if(!$order)  return $this->failed('未找到对应的订单数据，订单取消失败');

        if(in_array($order->order_type,[4,5]))  return $this->failed('拼团/秒杀订单不能删除');

        DB::beginTransaction();
        //记录取消订单状态和原因
        $res = Order::cancel($uuid, $order_id, $remark);
        if (!$res){
            DB::rollBack();
            return $this->failed('订单取消失败');
        }

        $datatime = date('Y-m-d H:i:s');
        //记录操作信息
        $data = [
            'order_id'      =>  $order_id,
            'operator'      =>  $order->recipient,
            'mobile'        =>  $order->phone,
            'record_type'   =>  4,
            'comment'       =>  '取消订单',
            'mark'          =>  $remark,
            'created_at'    =>  $datatime,
            'updated_at'    =>  $datatime,
        ];

        if(!OrderRecord::query()->insert($data)){
            DB::rollBack();
            return $this->failed('订单取消失败');
        }
        //库存回滚
        $CodeData = OrderService::upstock($order,$remark);


        if ($CodeData->code == 400 && $CodeData->message != '不能重複更新'){
            DB::rollBack();
            return $this->failed($CodeData->message);
        }

        //修改优惠券状态
        $has = OrderCoupon::query()->where('order_id',$order->id)->first('id');

        if($has){
            $out = OrderService::editCoupon($order->ordersn,3);
            if ($out->code == 400){
                DB::rollBack();
                return $this->failed($out->message);
            }
        }
        $order->status  =   -2;
        $order->save();
        DB::commit();
        return $this->success('订单取消成功');
    }


    /**
     * 确认收货
     * @param int $id
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function confirmReception(int $id, Request $request)
    {
        try{
            $uuid = $request->user()->uuid;
            //执行收货计划
            OrderService::doConfirmReception($id,$uuid);

            return $this->success('收货成功');
        }catch (\Exception $e){
            return $this->failed($e->getMessage());
        }
    }



    /**
     * 用户订单类型统计(用户)
     * @param Request $request
     * @return mixed
     */
    public function orderStatusNum(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'shop_id'  =>  'bail|required|integer',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $uuid       =   $request->user()->uuid;
        $shop_id    =   $request->input('shop_id',0);

        $data = Order::getStatusNum($uuid,$shop_id);
        return $this->success($data);
    }

    /**
     * 统计当前订单不同状态的数据(商家)
     * @param Request $request
     * @return mixed
     */
    public function orderNum(Request $request)
    {
        $shop_id    =   $request->input('shop_id');

        if(!$shop_id) return $this->failed('缺少店铺id');

        $data = Order::getStatusNum(null,$shop_id);
        return $this->success($data);
    }

    /**
     * 获取待结算金额
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getCountMoney(Request $request)
    {
        $shop_id    =   $request->get('shop_id');
        $money      =   0;
        Order::query()->where('status',0)->where('paid',0)->where('shop_id',$shop_id)->get(['money'])
            ->each(function ($item) use(&$money){
                $money += $item['money'] * 100;
            });

        return $this->success($money/100,'待结算金额');
    }

    /**
     * 支付金额为0的情况下，使用此回调
     * @param Request $request
     * @return mixed
     */
    public function order_notify(Request $request){
        $validator = Validator::make($request->all(),[
            'money'     =>   'bail|required|in:0',              //支付金额必须为0
            'order_sn'  =>   'bail|required|string',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $order_sn = $request->post('order_sn');

        $order          =   TarsHelper::servantFactory(OrderServant::class);
        $result         =   new resultMsg();
        $InNotifyData   =   new InNotifyData();

        $InNotifyData->ordersn      =   $order_sn;
        $InNotifyData->paid         =   0;
        $InNotifyData->paid_type    =   10; //无需支付

        $order->notifyOrderPayment($InNotifyData,$result);

        if($result->code != 200){
            return $this->failed($result->error);
        }

        return $this->success('ok');

    }

    /**
     * 订单修改（虚拟核销多次支付订单）
     * @param Request $request
     * @return mixed
     */
    public function orderNotify(Request $request){
        try{
            $input = $request->all();

            $ordServer  = TarsHelper::servantFactory(OrderServant::class);

            $inUpdate   =   new InUpdateOrder();
            $resultMsg  =   new resultMsg();

            $inUpdate->order_sn =   $input['outTradeNo'];
            $inUpdate->amount   =   $input['amount'];
            $inUpdate->status   =   1;

            $ordServer->updateOrder($inUpdate,$resultMsg);

            if($resultMsg->code != 200){
                return $this->failed($resultMsg->error);
            }

            return $this->success('ok');
        }catch (\Exception $e){
            return $this->failed($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 拼团系统订单状态修改
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doGroupOrder(Request $request){

        $order_sn   =   $request->get('order_sn');
        $client     =   new Client();

        $url    =   config('tars.group_host').'/api/groupBuy/common/payOrderCallback';
        var_dump($url);

        $data   =   ['order_sn' =>  $order_sn];

        //请求过去就行了，不做任何回调处理
        $request    =   $client->request('get',$url,['query'  =>  $data]);

        $body       =   $request->getBody();
        $bodyStr    = (string)$body;

        return  $this->success($bodyStr);

    }

    /**
 * @return mixed
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
    public function inteRate(){

        try{

            $client     =   new Client();

            $url    =   env('INTEGRAL_HOST').'/Laravel/integral/rate';

            $data   =   ['id' =>  1];

            //请求过去就行了，不做任何回调处理
            $request    =   $client->request('post',$url,['form_params'  =>  $data]);

            $body       =   $request->getBody();
            $bodyStr    =   json_decode($body,true);

            $info =   $bodyStr['data'];
            var_export($info['id']);

            return $this->success($info);
        }catch (\Exception $e){
            var_dump($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 通知秒杀系统订单状态
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doas(Request $request){
        //OrderService::doCallbackNotify($request->input('order_sn'),-2);
        //$a = OrderService::getPickTIme($request->input('order_sn'));
        $a = OrderService::integralHold([
            "integral_task_id"  =>  'ZNYX20201106141733976002',
            "uuid"              =>  '4d361ae262fa45e09a3cb826a87727c1',
            "merchant_id"       =>  28,
            "shop_id"           =>  28,
            "reduce_integral"   =>  10,
            "user_phone"        =>  '13016598031',
            "type"              =>   "4",
            "desc"              =>  "商家派发积分给分销员",
            "status"            =>  "2"
        ]);
        return $this->failed($a);
        /*var_dump('aaaa');
        OrderService::unifiedShare($request->input('order_sn'));*/


      /*  $template_param =   [
            'commodity_name'    =>  '黑色衬衫',
            'money'             =>  100,
        ];

        $data   =   [
            'phone_numbers' =>  $request->get('phone_numbers'),
            'sign_name'     =>  '邦邦科技',
            'template_code' =>  'SMS_200187033',
            'template_param'=>  json_encode($template_param),
        ];

        OrderService::sendSmsHttp($data);*/

        /*$data   =   [
            'platform'  =>  1,
            'role'      =>  1,
            'uuid'      =>  '425acb054c5f4d2cab040efcc3c18672',
            'notice_type'  =>  1,
            'title'     =>  '啊渣好骚啊',
            'subtitle'  =>  '实在是太骚了',
            'content'   =>  json_encode('啊渣穿了件女生的内裤，就骚的不行'),
            'sender'    =>  '邦邦科技',
        ];
        OrderService::collectNoticeHttp($data);*/
        /*try{
            $order  =   Order::query()->where('ordersn','20200924145103151411')->first();
            OrderService::doNoticeHttpBySale($order);

        }catch (\Exception $e){
            return  $this->failed($e->getMessage().':'.$e->getFile().':'.$e->getLine());
        }*/


        /*$client     =   new Client();

        $url        =   'https://bigjpg.com/api/task/';

        $headers=['X-API-KEY' => '033de9e540bd4f44814ca9d158ef31d4'];

        $data = [
            'style' =>  'photo',
            'noise' =>  '3',
            'x2' =>  '4',
            'input' =>  'C:\Users\Administrator\Desktop\image\919b207e76bfc1c92bd013fc5502892.jpg',
        ];

        //请求过去就行了，不做任何回调处理
        $request    =   $client->request('post',$url,['headers' =>  $headers,   'json'  =>  $data]);

        $body       =   $request->getBody();
        $bodyStr    =   json_decode($body,true);

        return  $bodyStr;*/

    }
}
