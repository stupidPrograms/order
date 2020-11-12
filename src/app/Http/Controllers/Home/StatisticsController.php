<?php


namespace App\Http\Controllers\Home;


use App\Api\Helpers\Api\ApiResponse;
use App\Data\ShopData;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderRecord;
use App\Tars\cservant\BB\UserService\User\classes\UserBasic;
use App\Tars\cservant\BB\UserService\User\UserServant;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\StatusCode;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\classes\UpdateData;
use App\Tars\cservant\ProductTcp\ProductService\ProductObj\ProductServant;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\resultMsg;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\classes\ShopInfo;
use App\Tars\cservant\Shop\ShopTcp\ShopObj\ShopServant;
use App\Tars\impl\TarsHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class
StatisticsController extends Controller
{
    use ApiResponse;

    /**
     * 订单操作记录
     * @param $id
     * @return mixed
     */
    public function operationalRecord($id)
    {
        $list = OrderRecord::query()->where('order_id', $id)->orderBy('created_at', 'desc')->get();
        return $this->success($list);
    }

    /**
     * 店铺销售统计
     * @param $shop_id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function shopStatistics($shop_id, Request $request)
    {
        $shops = ShopData::getAllSubShops($request->shop_servant, $request->shop_info);
        $shop_arr = array_keys($shops);
        //TODO 后期改成用单独表来记录销售统计数据
        $order = Order::query();

        $order_num_arr  =   Order::getShopStatusNum($shop_arr);
        $dist_order     =   $order->whereIn('shop_id', $shop_arr)->where('dist_code', '!=', null)->count();

        $yesterday      =   Carbon::yesterday()->toDateTimeString();
        $today          =   Carbon::today()->toDateTimeString();

        $all = $order->newQuery()->whereIn('shop_id', $shop_arr)->sum('money');

        $last_day = $order->newQuery()->whereIn('shop_id', $shop_arr)->where('created_at', '>=', $yesterday)->where('created_at', '<', $today)->sum('money');

        $order_all = $order->newQuery()->whereIn('shop_id', $shop_arr)->count();

        $order_day = $order->newQuery()->whereIn('shop_id', $shop_arr)->whereBetween('created_at', [$yesterday,$today])->count();

        $res = [
            'write_off'             =>      $order_num_arr[0]['write_off'],
            'express'               =>      $order_num_arr[0]['express'],
            'dist'                  =>      $dist_order,
            'earnings'              =>      $all,
            'yesterday_earnings'    =>      $last_day,
            'total_order'           =>      $order_all,
            'yesterday_order'       =>      $order_day,
            'visitor'               =>      0,
            'yesterday'             =>      0,
            'buyer'                 =>      0,
            'yesterday_buyer'       =>      0
        ];
        return $this->success($res);

    }

    /**
     * 订单消费统计(拼团/秒杀)
     * @param Request $request
     * @return mixed
     */
    public function statiOrderByActivity(Request $request){
        $validator      =   Validator::make($request->all(),[
            'store_id'  =>  'bail|required|numeric',
            'day'       =>  'bail|required|numeric|in:0,1,30',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $user           =   $request->user();
        $business_id    =   $user->uuid;
        $store_id       =   $request->get('store_id');
        $day            =   $request->get('day');

        //活动消费数据（拼团 / 秒杀）
        list($total_order,$pay_order,$sale_order)  =   $this->getStatiOrderByActivity($store_id,$business_id,$day);

        return  $this->success(compact('total_order','pay_order','sale_order'));
    }

    /**
     * 活动消费数据（拼团 / 秒杀）
     * @param $store_id
     * @param $business_id
     * @param $day
     * @return array
     */
    public function getStatiOrderByActivity($store_id,$business_id,$day){

        $OrderModel      =   $this->setOrderModel($store_id,$business_id,$day)->whereIn('order_type',[4,5]);

        //下订单数
        $total_order    =   $OrderModel->count();

        //支付订单数(也是支付数)
        $pay_order      =   $OrderModel->where('paid',1)->count();

        //核销订单数
        $sale_order     =   $OrderModel->where('status',4)->count();

        return  [$total_order,$pay_order,$sale_order];
    }

    /**
     * 分销消费统计（帮部落业务员端首页）
     * @param Request $request
     * @return mixed
     */
    public function statiOrderBySale(Request $request){
        $validator      =   Validator::make($request->all(),[
            'store_id'  =>  'bail|required|numeric',
            'day'       =>  'bail|required|numeric|in:0,1,30',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }


        $store_id       =   $request->get('store_id');
        $day            =   $request->get('day');

        //分销活动消费统计
        list($order_amount,$pay_order)  =   $this->getStatiOrderBySale($store_id,null,$day);

        return  $this->success(compact('order_amount','pay_order'));
    }

    /**
     * 分销活动消费统计
     * @param $store_id
     * @param $business_id
     * @param $day
     * @return array
     */
    public function getStatiOrderBySale($store_id,$business_id,$day){

        $OrderModel      =   $this->setOrderModel($store_id,$business_id,$day)->whereNotNull('dist_code');

        //交易金额
        $order_amount    =   $OrderModel->where('paid',1)->sum('pay_online');

        //支付订单数(也是支付数)
        $pay_order       =   $OrderModel->where('paid',1)->count();

        return  [$order_amount,$pay_order];
    }

    /**
     * 订单句柄
     * @param $store_id
     * @param $business_id
     * @param $day
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function setOrderModel($store_id,$business_id,$day){

        $model  =   Order::query()->where('shop_id',$store_id);

        if($business_id)    $model->where('business_id',$business_id);

        //0代表今天，1代表昨天,30天
        if(in_array($day,[0,1,30])){
            list($begin,$end) = ShopData::getTime($day);
            $model->whereBetween('created_at',[$begin,$end]);
        }

        return  $model;
    }

    /**
     * 数据折线统计图
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

            $user       =   $request->user();
            $business_id=   $user->uuid;
            $store_id   =   $request->get('store_id');
            $day        =   $request->get('day');
            $start      =   $request->get('start');
            $end        =   $request->get('end');

            $select     =   "COUNT(order_type != 6 OR NULL) online_order,COUNT(order_type = 6 OR NULL) offline_order,SUM(pay_online) pay_number,DATE_FORMAT(created_at,'%Y-%m-%d') date";

            $data       =   $this->countOrder($select,$store_id,$business_id,$day,$start,$end);

            return  $this->success(compact('data'));

        }catch (\Exception $e){
            return $this->failed('意外错误 ： '.$e->getMessage() .':'.$e->getLine() );
        }
    }

    /**
     * 订单数据统计
     * @param $select
     * @param $store_id
     * @param $business_id
     * @param $day
     * @param $start
     * @param $end
     * @return array
     */
    public function countOrder($select,$store_id,$business_id,$day,$start,$end){

        $model  =   Order::query()->selectRaw($select)->where('shop_id',$store_id)->where('business_id',$business_id)->where('paid',1);

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
            'online_order'   =>  0,
            'offline_order'     =>  0,
            'pay_number'    =>  0,
        ];
        $_collection = ShopData::getTimeList($start,$end,$data);

        $model->groupBy('date')->get()
            ->each(function ($item) use (&$_collection) {

                $_collection[$item->date] = [
                    'month'         =>  $item->date,
                    'online_order'  =>  $item->online_order,
                    'offline_order' =>  $item->offline_order,
                    'pay_number'    =>  $item->pay_number
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
     * 营收明细
     * @param Request $request
     * @return mixed
     */
    public function getOrderList(Request $request){
        $validator      =   Validator::make($request->all(),[
            'store_id'  =>  'bail|required',
            'month'     =>  'bail|required',
            'page'      =>  'bail|required',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $user       =   $request->user();
        $business_id=   $user->uuid;
        $page       =   $request->get('page');
        $store_id   =   $request->get('store_id');
        $month      =   $request->get('month');

        //计算月的开始和结束
        $start  =   date("Y-m-01 00:00:00",strtotime($month));

        $end    =   date('Y-m-d 23:59:59', strtotime("$month +1 month -1 day"));

        $select =   ['id','create_by_phone','ordersn','pay_online','created_at'];
        $model  =   Order::query()->select($select)->where('shop_id',$store_id)->where('business_id',$business_id)->where('paid',1)->whereBetween('created_at',[$start,$end]);

        $total  =   $model->count();
        $number =   $model->sum('pay_online');

        $data   =   $model->orderByDesc('id')->offset(($page - 1)*10)->limit(10)->get();

        return  $this->success(compact('data','number','total','page'));

    }

    /**
     * 订单权重统计
     * @param Request $request
     * @return mixed
     */
    public function getOrderTask(Request $request){
        try{

            //获取今日起始时间
            $beginTime  =   self::formatTime(mktime(0,0,0,date('m'),date('d'),date('Y')));
            $endTime    =   self::formatTime(mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1);

            //确认收货订单(已完成订单)
            //秒杀订单，拼团订单，核销订单，确认收货订单
            $select =   "shop_id,business_id,
                         count(status=4  AND order_type = 4  OR NULL) as  seckills,
                         count(status=4  AND order_type = 5  OR NULL) as groups,
                         count(status=4  OR NULL)   as  sale,
                         count(status=3  OR NULL)   as  received,
                         sum(if(paid =1, pay_online,0)) as money";

            $data   =   Order::query()->selectRaw($select)->groupBy('shop_id','business_id')->whereBetween('created_at',[$beginTime,$endTime])->get();

            return  $this->success($data);
        }catch (\Exception $e){
            return $this->failed('意外错误 ： '.$e->getMessage() .':'.$e->getLine() );
        }
    }

    /**
     * 格式化时间
     * @param $time
     * @return false|string
     */
    public static function formatTime($time){
        return  date('Y-m-d H:i:s',$time);
    }
}
