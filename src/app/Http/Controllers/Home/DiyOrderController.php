<?php
/**
 * 落地页模块
 */

namespace App\Http\Controllers\Home;

use App\Api\Helpers\Api\ApiResponse;
use App\Data\ShopData;
use App\Exports\OrderExport;
use App\Exports\OrdersExport;
use App\Models\Order;
use App\Tars\cservant\BB\UserService\User\classes\UserInfo;
use App\Tars\cservant\BB\UserService\User\UserServant;
use App\Tars\impl\TarsHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DiyOrderController extends Controller
{
    use ApiResponse;

    protected $userServant;

    /**
     * 获取用户系统服务配置
     * @return mixed
     */
    public function getUserServant(){
        return $this->userServant ??   $this->userServant = TarsHelper::servantFactory(UserServant::class);
    }

    /**
     * @param $uuid
     * @return UserInfo
     */
    public function getUserInfo($uuid){

        $userInfo   = new userInfo();
        $error      = '';

        $this->getUserServant()->getUserInfoByUuid($uuid,1,$userInfo,$error);

        return $userInfo;
    }

    /**
     * 数据简报
     * @param Request $request
     * @return mixed
     */
    public function brieOrder(Request $request){

        $validator      =   Validator::make($request->all(),[
            'channel_code'  =>  'bail|required',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        //渠道号
        $channel_code   =   $request->input('channel_code');
        $store_id       =   $request->input('store_id');

        //获取参与秒杀的人数
        $select     =   "COUNT(order_type = 4 OR NULL) as seckill";
        $killModel  =   Order::query()->selectRaw($select)->where('shop_id',$store_id)->where('paid',1)->where('channel_code','like',"$channel_code%")->first();
        $total_kill =   $killModel->seckill;

        //获取核销人数（秒杀下单已核销数 + 虚拟定金券已核销数）
        $select  =   "COUNT(order_type = 4 OR NULL) as sale";
        $sale    =   DB::table('orders')->selectRaw($select)->where('shop_id',$store_id)->where('channel_code','like',"$channel_code%")->where('status',4)->first();

        //计算总核销数
        $total_sale =   $sale->sale;

        return  $this->success(compact('total_kill','total_sale'));
    }

    /**
     * 折线统计图数据
     * @param Request $request
     * @return mixed
     */
    public function getOrderTrend(Request $request){
        $validator      =   Validator::make($request->all(),[
            'channel_code'  =>  'bail|required',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $channel_code   =   $request->input('channel_code');
        $type           =   $request->input('type',1);
        $store_id       =   $request->input('store_id');

        if($type == 1){
            //近七天
            $start  = date("Y-m-d 00:00:00",strtotime("-7 day"));
            $end    = date('Y-m-d 23:59:59',time());
        }

        if($type == 2){
            //本月
            $time   = date("Y-m-01 00:00:00",time());
            $start  = date("Y-m-01 00:00:00",time());
            $end    = date('Y-m-d 23:59:59', strtotime("$time +1 month -1 day"));
        }
        if($type == 3){
            //本年
            $start  = date("Y-01-01 00:00:00",time());
            $end    = date('Y-12-31 23:59:59', time());
        }
        if($type == 4){
            //时间段
            $start  = date("Y-m-d 00:00:00",strtotime($request->input('start')));
            $end    = date('Y-m-d 23:59:59', strtotime($request->input('end')));
        }

        //计算时间差值,以决定格式化时间格式
        $diff = strtotime($end) - strtotime($start);

        //分组条件 1天内按小时分组,否则按天/月分组
        //86400/1天 2678400/1月
        if($diff < 86400 && $diff > 0){
            $sort = '%H';
        }elseif($diff < 2678400){
            $sort = '%Y-%m-%d';
        }else{
            $sort = '%Y-%m';
        }
        //把数据添加时间按格式化时间分组求和,求和分两种,一种是直接求和,一种是满足case when条件的数据求和
        $select   =   "COUNT(w.order_type = 4 OR NULL) as num , DATE_FORMAT(w.created_at,'".$sort."') as datetime";

        //获取秒杀下单数
        $skill      =   ShopData::getSellerQuData('orders',$select,0,$start,$end,$channel_code,$store_id)->get();

        $resou_a    =   [];
        foreach ($skill as $item){
            $resou_a[$item->datetime]   =  $item->num;
        }

        //获取核销人数（秒杀下单已核销数 + 虚拟定金券已核销数）
        $select     =   "COUNT(w.order_type = 4 OR NULL) as total_sale,DATE_FORMAT(w.created_at,'".$sort."') as datetime";
        $sale       =   ShopData::getSellerQuData('orders',$select,1,$start,$end,$channel_code,$store_id)->get();

        $resou_b    =   [];
        foreach ($sale as $item){
            $resou_b[$item->datetime]   =   $item->total_sale;
        }


        return  $this->success(compact('resou_a','resou_b'));
    }

    /**
     * 数据表格
     * @param Request $request
     * @return mixed
     */
    public function getTotalList(Request $request){
        $validator      =   Validator::make($request->all(),[
            'channel_code'  =>  'bail|required',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $channel_code   =   $request->get('channel_code');
        $store_id       =   $request->input('store_id',0);

        //获取核销人数（秒杀下单已核销数）
        $select =   "COUNT(order_type = 4 OR NULL) as total_sale , channel_code";
        $total  =   DB::table('orders')->selectRaw($select)->whereIn('channel_code',$channel_code)->where('status',4)->where('shop_id',$store_id)->groupBy('channel_code')->get();

        //获取参与秒杀的人数
        $select     =   "channel_code,COUNT(order_type = 4 OR NULL) as total_kill";
        $sale_total =   Order::query()->selectRaw($select)->whereIn('channel_code',$channel_code)->where('shop_id',$store_id)->where('paid',1)->groupBy('channel_code')
            ->get()->each(function ($item) use ($total){

                $item->total_sale = 0;
                $sale = $total->where('channel_code', $item->channel_code)->first();

                if($sale)   $item->total_sale = $sale->total_sale;

            });

        return  $this->success($sale_total);
    }

    /**
     * 秒杀列表
     * @param Request $request
     * @return mixed
     */
    public function getSkilList(Request $request){

        $validator      =   Validator::make($request->all(),[
            'channel_code'  =>  'bail|required',
            'type'          =>  'bail|required|in:0,1',
            'page_size'     =>  'bail|required|integer|min:10',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $user       =   $request->user();
        $business_id=   $user->uuid;
        $code       =   $request->get('channel_code');
        $mobile     =   $request->get('mobile');
        $start      =   $request->get('start');
        $end        =   $request->get('end');
        $page       =   $request->get('page',1);
        $type       =   $request->get('type',1);
        $check      =   $request->get('check',0);
        $page_size  =   $request->get('page_size');

        $select =   ['o.id','o.uuid','o.create_by_phone as phone','o.pay_online','o.channel_code','o.status','o.paid_at','g.goods_name'];

        $model  =   DB::table('orders as o')->select($select)->where('o.business_id',$business_id)->where('o.order_type',4)->where('status','!=',-2)
            ->leftJoin('orders_goods as g','o.id','=','g.order_id');

        if($mobile) $model->where('o.create_by_phone','like',"%$mobile%");

        if($start && $end)  $model->whereBetween('o.paid_at',[$start,$end]);

        //是否模糊匹配，默认全等不匹配
        if($check == 0){
            $model->where('o.channel_code',$code);
        }else{
            $model->where('o.channel_code','like',"$code%");
        }

        $total  =   $model->count();
        //默认数据分页
        if($type)   $model->offset(($page - 1) * $page_size)->limit($page_size);

        $data = $model->orderByDesc('o.id')
            ->get()->each(function ($query){
                $query->user_name   =   $this->getUserInfo($query->uuid)->nickname;
        });

        //默认输出数据列表
        if($type)   return  $this->success(compact('data','total','page'));

        //数据导出
        $collection = [
            ['序号', '用户ID','渠道号','联系电话', '秒杀的商品名称', '购买支付金额', '是否已核销','购买时间']
        ];

        foreach ($data as $item) {
            if($item->status == 4){
                $order_type = 2;
            }else{
                $order_type = 1;
            }

            $collection[] = [
                $item->id,
                $item->user_name,
                $item->channel_code,
                $item->phone,
                $item->goods_name,
                $item->pay_online,
                Order::TYPE[$order_type],
                $item->paid_at
            ];
        }

        return Excel::download(new OrdersExport($collection), '交易记录表.xlsx',null,[
            'widths' => [
                'A' => 5, 'B' => 10, 'C' => 15, 'D' => 25, 'E' => 10, 'F' => 10,'G' => 10,'H'=>20
            ]
        ]);
    }


    /**
     * 核销记录列表
     * @param Request $request
     * @return mixed
     */
    public function getSaleList(Request $request){
        $validator      =   Validator::make($request->all(),[
            'channel_code'  =>  'bail|required',
            'type'          =>  'bail|required|in:0,1',
            'check'         =>  'bail|required|in:0,1',
            'page_size'     =>  'bail|required|integer|min:10',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $user       =   $request->user();
        $business_id=   $user->uuid;
        $type       =   $request->get('type',1);
        $check      =   $request->get('check',0);
        $code       =   $request->get('channel_code');
        $mobile     =   $request->get('mobile');
        $start      =   $request->get('start');
        $end        =   $request->get('end');
        $page       =   $request->get('page',1);
        $page_size  =   $request->get('page_size');

        $select =   ['o.id','o.uuid','o.create_by_phone as phone','o.order_type','o.channel_code','o.updated_at','g.goods_name','c.coupon_type'];

        $model  =   DB::table('orders as o')->select($select)->where('o.business_id',$business_id)->whereIn('o.order_type',[4,6])->where('o.status',4)

            ->leftJoin('orders_goods as g','o.id','=','g.order_id')

            ->leftJoin('order_coupon as c','o.id','=','c.order_id');

        //是否模糊匹配，默认全等不匹配
        if($check == 0){
            $model->where('o.channel_code',$code);
        }else{
            $model->where('o.channel_code','like',"$code%");
        };

        if($mobile) $model->where('o.create_by_phone','like',"%$mobile%");

        if($start && $end)  $model->whereBetween('o.paid_at',[$start,$end]);

        if($type)  $model->offset(($page - 1) * $page_size)->limit($page_size);

        $data = $model->orderByDesc('o.id')->get()->each(function ($query){
            $query->user_name   =   $this->getUserInfo($query->uuid)->nickname;
        })->toArray();


        foreach ($data as $k => $item){
            if(in_array($item->coupon_type,[1,2]))   unset($data[$k]);
        }


        //默认输出数据列表
        if($type){
            $total  =   count($data);
            return  $this->success(compact('data','total','page'));
        }

        //数据导出
        $collection = [
            ['序号', '用户ID','渠道号', '联系电话', '核销类型', '名称', '核销时间']
        ];

        foreach ($data as $item) {

            $collection[] = [
                $item->id,
                $item->user_name,
                $item->channel_code,
                $item->phone,
                Order::ORDER_TYPE[$item->order_type],
                $item->goods_name,
                $item->updated_at
            ];
        }

        return Excel::download(new OrdersExport($collection), '核销记录表.xlsx',null, [
                'widths' => [
                    'A' => 5, 'B' => 10, 'C' => 15, 'D' => 25, 'E' => 10, 'F' => 10,'G' => 20
                ]
        ]);
    }

    /**
     * 落地页获取订单资源
     * @param Request $request
     * @return mixed
     */
    public function getOrderResou(Request $request){
        $validator      =   Validator::make($request->all(),[
            'store_id' =>  'bail|required',
            'type'     =>  'bail|required|in:0,1,2,3',
        ]);

        if($error = $validator->errors()->first()){
            return $this->failed($error);
        }

        $store_id       =   $request->get('store_id');
        $type           =   $request->get('type');

        //一次性获取三个状态
        if($type == 3){

            $data   =   [];

            for ($i = 0;$i<3;$i++){
                $model  =   $this->getAnalysis($store_id,$i);

                $data[$i]['order_total']    =   $model->count();
                $data[$i]['money_total']    =   $model->sum('pay_online');

            }
            return  $this->success($data);
        }

        //获取单个状态
        $model  =   $this->getAnalysis($store_id,$type);

        $order_total    =   $model->count();
        $money_total    =   $model->sum('pay_online');

        return  $this->success(compact('order_total','money_total'));
    }

    public function getAnalysis($store_id,$type){

        $model  =   Order::query()->where('shop_id',$store_id)->whereNotNull('poster_code')->where('order_type',4);

        if($type){
            //判断条件
            $cond   =    [ 1 => 'paid' , 2 => 'status' ];

            //条件值
            $value  =   [ 1 => 1 , 2 => 4 ];

            $model->where($cond[$type],$value[$type]);
        }

        return  $model;
    }

    /**
     *  导出数据统计
     * @param Request $request
     * @return mixed
     */
    public function exportOrder(Request $request){
        $uuid   =   $request->get('uuid');

        if(!$uuid)   return  $this->failed('缺少用户uuid');

        //依次是用户uuid，下单数，下单金额，支付数，支付金额，核销数，核销金额
        $select =   'uuid,
        COUNT(id) as order_total,SUM(money) as order_money,
        COUNT(id AND paid = 1) as pay_total,SUM(IF(paid = 1,pay_online,0)) as pay_money,
        COUNT(id AND status = 4) as sale_total,SUM(IF(status = 4,pay_online,0)) as sale_money';

        $data = Order::query()->selectRaw($select)->whereIn('uuid',$uuid)->whereNotNull('poster_code')->whereIn('order_type',[1,2,4])->groupBy('uuid')
                ->get()->each(function ($query){
                    $query->user_name   =   $this->getUserInfo($query->uuid)->nickname;
                });

        return  $this->success(compact('data'));
    }
}
