<?php


namespace App\Http\Controllers\Home;


use App\Api\Helpers\Api\ApiResponse;
use App\Data\ShopData;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHirePur;
use App\Models\OrderRecord;
use App\Services\OrderService;
use App\Tars\cservant\dist\distServer\performanceObj\classes\CommonOutParam;
use App\Tars\cservant\dist\distServer\performanceObj\classes\inputUpgrade;
use App\Tars\cservant\dist\distServer\performanceObj\classes\UpdateParam;
use App\Tars\cservant\dist\distServer\performanceObj\PerformanceServiceServant;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\Status;
use App\Tars\cservant\PAY\PayService\PayTcp\PayServiceServant;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\ShopInfo;
use App\Tars\cservant\BB\Shop\ShopTcp\ShopServant;
use App\Tars\impl\TarsHelper;
use App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\IntegralTafServiceServant;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\orderCounts;
use App\Tars\servant\OrderSystem\OrderServer\OrderObj\classes\resultMsg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class ShopOrderController extends Controller
{
    use ApiResponse;

    /**
     * 店铺订单列表，商家后台使用
     * @param int $shop_id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function index(int $shop_id, Request $request)
    {
        try{
            $rows           =   $request->get('rows', '10');
            $ordersn        =   $request->get('ordersn', '');     //订单号
            $recipient      =   $request->get('recipient', '');   //收货人
            $phone          =   $request->get('phone', '');       //联系电话
            $goods_name     =   $request->get('goods_name', '');  //商品名称
            $shop_name      =   $request->get('shop_name', '');   //店铺名称
            $order_type     =   $request->get('order_type');      //订单类型：0全部，1.在线订单；2.线下核销；3.积分订单
            $order_source   =   $request->get('order_source', '');//订单来源: 0. 购买商品/积分 2.分销
            $status         =   $request->get('status');          //订单状态 -4核销，0等待付款；1、已付款，等待发货；2、已经发货；3、确认收货；4、已核销
            $start          =   $request->get('start', '');
            $end            =   $request->get('end', '');

            /** @var ShopServant $shop_servant */
            $shop_servant   = $request->shop_servant;
            /** @var ShopInfo $shop_info */
            $shop_info      = $request->shop_info;


            //这里保存一下店铺信息
            $shops = ShopData::getAllSubShops($shop_servant,$shop_info,$shop_name);
            $shop_arr = array_keys($shops); // 拿到所有店铺的id

            foreach ($shop_arr as $shop_id){
                //此处处理因服务重启而丢失处理超时未支付的订单
                OrderService::checkOffOrder($shop_id);

                //7天后为收货订单修改为已收货
                OrderService::confirmReceipt($shop_id);
            }

            //获取店铺订单列表
            $order_list = Order::getShopOrderList($rows,$shop_arr,$ordersn,$recipient,$phone,$goods_name,$order_type,$order_source,$status,$start,$end);

            $data           =   $order_list->items();
            $current_page   =   $order_list->currentPage();
            $total          =   $order_list->total();

            return $this->success(compact('data','current_page','total'));
        }catch (\Exception $e){
            return  $this->failed($e->getMessage());
        }
    }

    /**
     * 查询单个订单详情
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $order = Order::withTrashed()->where('id', $id)->with(['orderGoods'])->with([
            'orderCoupon' => function($query){
                $query->select('order_id','coupon_name','coupon_type','amount','reduction_money');
        }])->first();

        if(!$order){
            return $this->failed('暂无该订单数据');
        }

        //核销已支付金额
        $order->paidMoney   =   ($order->pay_offline * 100 - $order->surplus_money * 100) / 100;

        //核销支付记录
        $order->saleInfo    =   OrderHirePur::getSaleInfo($order->id);

        return $this->success($order);

    }


    /**
     * 店铺后台修改订单
     * @param Request $request
     * @param $id
     * @return mixed|null
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'type' => [
                'required',
                Rule::in(['express', 'money', 'close', 'mark','order_sn']),
            ],
        ]);

        if ($validate->fails()) {
            return $this->failed($validate->errors()->first());
        }


        $shop_id = Order::query()->where('id',$id)->value('shop_id');
        if(!$shop_id){
            return  $this->failed('暂无该订单数据');
        }
        $shopObj = new ShopData($shop_id);
        $shopInfo = $shopObj->getShopInfo();

        $mobile     =   $shopInfo->mobile;
        $operator   =   $shopInfo->surname;

        switch ($request->input('type')){
            case 'express':     //发货物流信息
                $response = $this->sendExpress($request, $id, $mobile, $operator);
                break;
            case 'money':       //修改金额
                $response = $this->editMoney($request, $id, $mobile, $operator);
                break;
            case 'close':       //关闭订单
                $response = $this->closeOrder($request, $id, $mobile, $operator);
                break;
            case 'mark':        //备注订单
                $response = $this->markOrder($request, $id, $mobile, $operator);
                break;
            default :
                return null;
        }
        return $response;
    }

    /**
     * 发货物流信息
     * @param $request
     * @param $id
     * @param $mobile
     * @param $operator
     * @return mixed
     */
    private function sendExpress($request, $id ,$mobile, $operator)
    {
        $data = [
            'express_code'  =>  $request->express_code,
            'express_name'  =>  $request->express_name,
            'status'        =>  2
        ];

        $res = Order::query()->where('id', $id)->update($data);

        $record = [
            'order_id'      =>  $id,
            'mobile'        =>  $mobile,
            'comment'       =>  '进行了发货操作',
            'mark'          =>  '商品已发货',
            'record_type'   =>  1,
            'operator'      =>  $operator
        ];
        (new OrderRecord())->addRecord($record);

        if (!$res)  return $this->failed('修改订单失败');

        return $this->success('修改订单成功');
    }

    /**
     * 修改金额
     * @param $request
     * @param $id
     * @param $mobile
     * @param $operator
     * @return mixed
     * @throws \Exception
     */
    private function editMoney($request, $id, $mobile, $operator)
    {

        $data = [
            'money'         =>  $request->money,
            'pay_online'    =>  $request->money
        ];
        $this->updateOrderAmount($request->order_sn,$request->money*100);
        $res = Order::query()->where('id', $id)->update($data);

        $record = [
            'order_id'      =>  $id,
            'mobile'        =>  $mobile,
            'comment'       =>  '进行了修改金额操作',
            'mark'          =>  '进行了修改金额操作',
            'record_type'   =>  2,
            'operator'      =>  $operator
        ];

        (new OrderRecord())->addRecord($record);

        if (!$res)  return $this->failed('修改订单金额失败');

        return $this->success('修改订单金额成功');
    }

    /**
     * 修改支付金额
     * @param $order_sn
     * @param $amount
     * @return bool
     * @throws \Exception
     */
    private function updateOrderAmount($order_sn,$amount){
        $pay_servant = TarsHelper::servantFactory(PayServiceServant::class);
        $pay_status  = new Status();

        $pay_servant->updateOrderAmount($order_sn,$amount,$pay_status);
        if ($pay_status->err){
            throw new \Exception('支付系统错误'.$pay_status->msg);
        }
    }

    /**
     * 关闭订单
     * @param $request
     * @param $id
     * @param $mobile
     * @param $operator
     * @return mixed
     */
    private function closeOrder($request, $id, $mobile, $operator)
    {
        $order_info         =   Order::orderInfo($id);

        if ($order_info->status !== 0)  return $this->failed('此订单不是待付款订单，不可关闭');

        if(in_array($order_info->order_type,[4,5])) return $this->failed('拼团订单或者秒杀订单不可关闭');

        $remarks = '商家关闭订单';

        $CodeData = OrderService::upstock($order_info,$remarks);

        if ($CodeData->code == 400){
            return $this->failed($CodeData->message);
        }


        $res = Order::query()->where('id', $id)->update(['status' => -2]);

        $record = [
            'order_id'      =>  $id,
            'mobile'        =>  $mobile,
            'comment'       =>  '关闭订单',
            'mark'          =>  '关闭订单',
            'record_type'   =>  3,
            'operator'      =>  $operator
        ];

        OrderRecord::query()->create($record);


        if (!$res){
            return $this->failed('修改订单状态失败');
        }
        return $this->success('修改订单状态成功');
    }

    /**
     * 备注订单
     * @param $request
     * @param $id
     * @param $mobile
     * @param $operator
     * @return mixed
     * @throws \Exception
     */
    private function markOrder($request, $id, $mobile, $operator)
    {
        if(mb_strlen($request->mark) > 256){
            return $this->failed('备注长度不能超过 256个字符');
        }

        $record = [
            'order_id'      => $id,
            'mobile'        => $mobile,
            'mark'          => $request->mark,
            'comment'       => '备注订单',
            'record_type'   => 4,
            'operator'      => $operator
        ];

        return DB::transaction(function ()use($record,$id){

            OrderRecord::query()->create($record);

            $order = Order::query()->where('id',$id)->firstOrFail();

            $order->comment = $record['mark'];

            if ($order->save()) return $this->success('备注订单状态成功');

            return $this->failed("备注订单失败: ".$record['mark']);
        });
    }


    //输入核销码，完成商品核销
    public function updateSale(Request $request){
        $id         = $request->get('id');
        $sale_code  = $request->get('sale_code');

        if(empty($id))  return $this->failed('id不能为空');

        if(empty($sale_code))   return $this->failed('核销码不能为空');

        $has = Order::query()->where('id',$id)->where('sale_code',$sale_code)->where('status',-4)->where('paid',1)->first([
            'id','uuid','money','gift_points','recipient','phone','ordersn','dist_code','env_domain_id','ordersn','uuid','shop_id','status'
        ]);

        if(!$has)  return $this->failed('未找到此核销码对应的核销产品');

        //发放对应的积分，商家扣除，用户增加积分
        if($has->gift_points){
            //若是分销商品，则走分销流程
            if($has->dist_code) $this->updateRecord($has->id,$has->shop_id,$has->ordersn);

            //TODO 修改商家积分->待结算;
            $this->giveUserPointsBuy($has->uuid,$has->gift_points,$has->shop_id,$has->ordersn);

        }

        //一次性购买到指定金额升级
        $this->checkUpgrade($has->uuid,$has->shop_id,$has->env_domain_id,$has->money,$has->ordersn);

        $time = date('Y-m-d H:i:s');
        //记录操作信息
        $data = [
            'order_id'      =>  $has->id,
            'operator'      =>  $has->recipient,
            'mobile'        =>  $has->phone,
            'record_type'   =>  4,
            'comment'       =>  '核销码核销完成',
            'mark'          =>  '核销码核销完成',
            'created_at'    =>  $time,
            'updated_at'    =>  $time,
        ];

        OrderRecord::query()->insert($data);

        $has->status = 4;
        $has->save();

        return $this->success('订单核销成功');
    }

    /**
     * 修改分销状态
     * @param $id
     * @param $shop_id
     * @param $ordersn
     */
    public function updateRecord($id,$shop_id,$ordersn){
        $performance_servant = TarsHelper::servantFactory(PerformanceServiceServant::class);
        $update_param               =   new UpdateParam;

        $update_param->tranId       =   $id;
        $update_param->status       =   3;
        $update_param->businessId   =   $shop_id;

        $common = new CommonOutParam;

        $performance_servant->updateRecord($update_param, $common);

        if ($common->code == 400) {
            throw new InvalidResourceException('销分记录添加异常：订单号:'.$ordersn.';错误信息'.$common->message);
        }
    }

    /**
     *  一次性购买到指定金额升级
     * @param $uuid
     * @param $shop_id
     * @param $domain_id
     * @param $money
     * @param $ordersn
     * @return bool
     */
    public function checkUpgrade($uuid,$shop_id,$domain_id,$money,$ordersn){
        $dist_performance = TarsHelper::servantFactory(PerformanceServiceServant::class);
        $common = new CommonOutParam();
        //一次性消费到指定金额晋级
        $upgrade = new inputUpgrade();

        $upgrade->uuid      = $uuid;
        $upgrade->store_id  = $shop_id;
        $upgrade->domainId  = $domain_id;
        $upgrade->money     = $money;

        $dist_performance->checkUpgrade($upgrade,$common);

        if ($common->code == 400){
            throw new InvalidResourceException('分销记录添加异常：订单号:'.$$ordersn.';错误信息'.$common->message);
        }
        return true;
    }

    /**
     * 修改商家积分
     * @param $uuid
     * @param $gift_points
     * @param $shop_id
     * @param $ordersn
     */
    public function giveUserPointsBuy($uuid,$gift_points,$shop_id,$ordersn){
        //TODO 修改商家积分->待结算;
        $integral       =   TarsHelper::servantFactory(IntegralTafServiceServant::class);
        $InGiveUserBuy  =   new \App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\InGiveUserBuy();
        $out_params     =   new \App\Tars\cservant\IntegralSystem\IntegralServer\IntegralObj\classes\resultMsg();

        $InGiveUserBuy->uuid    = $uuid;
        $InGiveUserBuy->points  = $gift_points;
        $InGiveUserBuy->shop_id = $shop_id;

        $integral->giveUserPointsBuy($InGiveUserBuy, $out_params);
        if ($out_params->code !== 200){
            throw new InvalidResourceException('销分记录添加异常：订单号:'.$ordersn.';错误信息'.$out_params->error);
        }
    }

    /**
     * 统计当前店铺的订单数量
     * @param Request $request
     * @return mixed
     */
    public function getOrderCount(Request $request)
    {
        $store_id = $request->input('store_id');

        try {
            if (!$store_id) return $this->failed('缺少店铺id');

            //店铺订单总销量
            $sellCount = Order::withTrashed()->from('orders as o')->where('o.shop_id', $store_id)->whereIn('o.status', [-4, 1, 2, 3, 4])
                ->leftJoin('orders_goods as g', 'o.id', '=', 'g.order_id')->sum('g.num');

            return $this->success(compact('sellCount'));

        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 修改拼团订单的拼团状态
     * @param Request $request
     * @return mixed
     */
    public function modifyGroupOrder(Request $request){
        try{
            $group_code =       $request->input('group_code');

            if(!$group_code)    return  $this->failed('缺少拼团码');

            $shop_id   =        $request->input('store_id');

            if(!$shop_id)   return  $this->failed('缺少店铺id');

            $upd       =    Order::query()->where('group_code',$group_code)->where('shop_id',$shop_id)->update(['group_success' => 1]);

            if(!$upd)       return  $this->failed('更新失败');

            return  $this->success('修改成功');
        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }
}
