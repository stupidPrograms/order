<?php


namespace App\Http\Controllers\Home;


use App\Api\Helpers\Api\ApiResponse;
use App\Data\ShopData;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminOrderController extends Controller
{
    use ApiResponse;

    //订单句柄(总数)
    protected   $totalModel;

    //订单句柄(昨日)
    protected   $yesterdayModel;


    protected   $store_id;


    /**
     * 数据简报
     * @param Request $request
     * @return mixed
     */
    public function brieOrder(Request $request){

        try{
            $validator      =   Validator::make($request->all(),[
                'store_id'  =>  'bail|required',
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $store_id   =   $request->get('store_id');

            //总消费数据
            list($order_num_total,$money_total,$num_total,$aver_money_total)    =   $this->getTotal($store_id);

            //今日消费数据
            list($order_num_today,$money_today,$num_today,$aver_money_today)    =   $this->getToday($store_id);

            //昨日消费数据
            list($order_num_yesterday,$money_yesterday,$num_yesterday,$aver_money_yesterday)    =   $this->getYesterday($store_id);


            $this->todayModel       =   null;
            $this->yesterdayModel   =   null;

            $data   =   [
                'order_num_total'       =>      $order_num_total,       //总订单数
                'money_total'           =>      $money_total,           //总支付金额
                'num_total'             =>      $num_total,             //总支付数
                'aver_money_total'      =>      $aver_money_total,      //总平均消费

                'order_num_today'       =>      $order_num_today,       //今日订单数
                'money_today'           =>      $money_today,           //今日支付金额
                'num_today'             =>      $num_today,             //今日支付数
                'aver_money_today'      =>      $aver_money_today,      //今日平均消费

                'order_num_yesterday'   =>      $order_num_yesterday,   //昨日订单数
                'money_yesterday'       =>      $money_yesterday,       //昨日支付金额
                'num_yesterday'         =>      $num_yesterday,         //昨日支付数
                'aver_money_yesterday'  =>      $aver_money_yesterday,  //昨日平均消费
            ];

            return  $this->success($data);
        }catch (\Exception $e){
            return $this->failed('意外错误 ： '.$e->getMessage() .':'.$e->getLine() );
        }
    }

    /**
     * 总消费数据
     * @param $store_id
     * @return array
     */
    public function getTotal($store_id){

        $totalModel        =   $this->setOrderModel($store_id,99);

        //总订单数
        $order_num_total   =   $totalModel->count();

        //总收入金额(也是支付金额)
        $money_total       =   $totalModel->where('paid',1)->sum('pay_online');

        //总交易成功订单数(也是支付数)
        $num_total         =   $totalModel->where('paid',1)->count();

        //平均消费    (初始化为0)
        $aver_money_today  =   0;

        if($money_total && $num_total)    $aver_money_today       =   round($money_total  /  $num_total,2);

        return  [$order_num_total,$money_total,$num_total,$aver_money_today];
    }

    /**
     * 今日消费数据
     * @param $store_id
     * @return array
     */
    public function getToday($store_id){

        $todayModel        =   $this->setOrderModel($store_id,0);

        //总订单数
        $order_num_today   =   $todayModel->count();

        //总收入金额(也是支付金额)
        $money_today       =   $todayModel->where('paid',1)->sum('pay_online');

        //总交易成功订单数(也是支付数)
        $num_today         =   $todayModel->where('paid',1)->count();

        //平均消费    (初始化为0)
        $aver_money_today  =   0;

        if($money_today && $num_today)    $aver_money_today       =   round($money_today  /  $num_today,2);

        return  [$order_num_today,$money_today,$num_today,$aver_money_today];
    }

    /**
     * 昨日消费数据
     * @param $store_id
     * @return array
     */
    public function getYesterday($store_id){

        $yesterdayModel         =   $this->setOrderModel($store_id,1);

        //昨日订单数
        $order_num_yesterday    =   $yesterdayModel->count();

        //昨日总收入金额(也是支付金额)
        $money_yesterday        =   $yesterdayModel->where('paid',1)->sum('pay_online');

        //昨日交易成功订单数(也是支付数)
        $num_yesterday          =   $yesterdayModel->where('paid',1)->count();

        //昨日平均消费
        $aver_money_yesterday   =   0;
        if($money_yesterday && $num_yesterday)  $aver_money_yesterday   =   round($money_yesterday  /  $num_yesterday,2);

        return  [$order_num_yesterday,$money_yesterday,$num_yesterday,$aver_money_yesterday];
    }

    /**
     * 订单句柄
     * @param $store_id
     * @param $day
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function setOrderModel($store_id,$day){

        $model  =   Order::query()->where('shop_id',$store_id);

        //0代表今天，1代表昨天
        if(in_array($day,[0,1])){
            list($begin,$end) = ShopData::getTime($day);
            $model->whereBetween('created_at',[$begin,$end]);
        }

        return  $model;
    }


    /**
     * 待处理事务
     * @param Request $request
     * @return mixed
     */
    public function getPendingOrder(Request $request){
        try{
            $validator      =   Validator::make($request->all(),[
                'store_id'  =>  'bail|required',
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $store_id   =   $request->get('store_id');

            //待发货订单
            $pendOrder  =   Order::query()->where('shop_id',$store_id)->where('status',1)->count();

            //待核销订单
            $saleOrder  =   Order::query()->where('shop_id',$store_id)->whereIn('status',[-5,-4,5])->count();

            return  $this->success(compact('pendOrder','saleOrder'));

        }catch (\Exception $e){
            return $this->failed('意外错误 ： '.$e->getMessage() .':'.$e->getLine() );
        }
    }

    /**
     * 概括首页折线统计图
     * @param Request $request
     * @return mixed
     */
    public function getOrderTrend(Request $request){
        try{
            $validator      =   Validator::make($request->all(),[
                'store_id'  =>  'bail|required',
                'day'       =>  'bail|integer|in:7,30',
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $store_id   =   $request->get('store_id');
            $day        =   $request->get('day');
            $start      =   $request->get('start');
            $end        =   $request->get('end');

            $select     =   "COUNT(distinct uuid) count_order,COUNT(distinct uuid AND paid = 1) pay_order,DATE_FORMAT(created_at,'%Y-%m-%d') date";

            $collection =   $this->countOrder($select,$store_id,$day,$start,$end);

            return  $this->success(compact('collection'));

        }catch (\Exception $e){
            return $this->failed('意外错误 ： '.$e->getMessage() .':'.$e->getLine() );
        }
    }

    /**
     * 订单数据统计
     * @param $select
     * @param $store_id
     * @param $day
     * @param $start
     * @param $end
     * @return array
     */
    public function countOrder($select,$store_id,$day,$start,$end){

        $model  =   Order::query()->selectRaw($select)->where('shop_id',$store_id);

        //获取天数
        if(in_array($day,[7,30])){
            list($begin,$end) = ShopData::getTime($day);
            $model->whereBetween('created_at',[$begin,$end]);

            //开始时间，结束时间
            $start  =   strtotime($begin);
            $end    =   strtotime($end);

        }elseif($start && $end){

            //若选择了时间
            $model->whereBetween('created_at',[$start,$end]);

            //开始时间，结束时间
            $start  =   strtotime($start);
            $end    =   strtotime($end);
        }

        //获取时间结构
        $data   =   [
            'count_order'   =>  0,
            'pay_order'     =>  0,
        ];

        $_collection = ShopData::getTimeList($start,$end,$data);

        $model->groupBy('date')->get()
            ->each(function ($item) use (&$_collection) {

                $_collection[$item->date] = [
                    'month'         =>  $item->date,
                    'count_order'   =>  $item->count_order,
                    'pay_order'     =>  $item->pay_order,
                ];

            });

        //数据整理
        $collection = [];
        foreach ($_collection as $item){
            $collection[] = $item;
        }

        return $collection;
    }

    /**
     * 漏斗數據
     * @param Request $request
     * @return mixed
     */
    public function getOrderType(Request $request){
        try{
            $validator      =   Validator::make($request->all(),[
                'store_id'  =>  'bail|required',
                'day'       =>  'bail|integer|in:7,30',
            ]);

            if($error = $validator->errors()->first()){
                return $this->failed($error);
            }

            $store_id   =   $request->get('store_id');
            $day        =   $request->get('day');
            $start      =   $request->get('start');
            $end        =   $request->get('end');
            $select     =   'COUNT(distinct uuid) count_order,COUNT(distinct uuid AND paid = 1 ) pay_order';

            $model      =   Order::query()->selectRaw($select)->where('shop_id',$store_id);

            //获取天数
            if(in_array($day,[7,30])){

                list($begin,$end) = ShopData::getTime($day);
                $model->whereBetween('created_at',[$begin,$end]);

            }elseif($start && $end){

                //若选择了时间
                $model->whereBetween('created_at',[$start,$end]);

            }

            $data   =   $model->first();

            return  $this->success($data);
        }catch (\Exception $e){
            return $this->failed('意外错误 ： '.$e->getMessage() .':'.$e->getLine() );
        }
    }


}
