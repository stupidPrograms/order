<?php


namespace App\Data;


use App\Tars\cservant\BB\Shop\ShopTcp\classes\resultMsg;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\ShopInfo;
use App\Tars\cservant\BB\Shop\ShopTcp\ShopServant;
use App\Tars\impl\TarsHelper;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Illuminate\Support\Facades\DB;

class ShopData
{
    /**店铺id*/
    private $store_id;

    /**店铺服务*/
    private $shopServant;

    /**店铺详细数据*/
    private $shopInfo;

    private static $time;

    public function __construct($store_id = 0)
    {
        $this->store_id = $store_id;
    }

    /**
     * 查找所有子店
     * @param ShopServant $shop_servant
     * @param ShopInfo $shop_info
     * @param null $filterShopName
     * @return mixed
     * @throws \Exception
     */
    public static function getAllSubShops(ShopServant $shop_servant, ShopInfo $shop_info, $filterShopName = null){
        $shop_id = $shop_info->id;
        //这里保存一下店铺信息
        $shops[$shop_id] = $shop_info;

        //这里判断如果是多店的话，需要把子店的订单也一起查询出来

        if (!$shop_info->pid && $shop_info->shoptype == 2){ // 没有上级店铺且类型为连锁店，说明自己就是多店上级

            $resultMsg      =   new resultMsg();
            $outGetArrayId  =   [];
            $shop_servant->getSubShop($shop_id, $resultMsg, $outGetArrayId); //拿到所有的子店

            if (!empty($outGetArrayId)){
                foreach ($outGetArrayId as $index => $id) {

                    $info       = new ShopInfo();
                    $resultMsg  = new resultMsg();
                    $shop_servant->shopInfo($id,$resultMsg,$info);

                    if ($filterShopName) {
                        if (strpos($info->name,$filterShopName) ===false) { //查找店铺名称是否包含筛选名称
                            continue;
                        }
                    }

                    //把店铺信息加上去
                    $shops[$id] = $info;
                }
                //throw new \Exception("无法获取子店信息：".$resultMsg->msg);
            }
        }
        return $shops;
    }

    public function getShopInfo(){
        return $this->shopInfo ?? $this->setSopInfo();
    }

    public function setSopInfo(){
        $shopService   =    $this->getShopService();
        $resultMsg     =    new resultMsg();
        $shopInfo      =    new ShopInfo();

        $shopService->shopInfo($this->store_id,$resultMsg,$shopInfo);

        if($resultMsg->msg == '店铺不存在') throw new BadRequestHttpException('店铺不存在');

        return $this->shopInfo = $shopInfo;
    }


    public function getShopService(){
        return $this->shopServant ?? $this->setShopService();
    }

    public function setShopService(){
        return $this->shopServant   =   TarsHelper::servantFactory(ShopServant::class);
    }

    /**
     * 计算选中天的其实时间
     * @param $day
     * @return array
     */
    public static function getTime($day){

        $beginTime = '';$endTime = '';

        //获取今天，昨天，前天起始时间
        if(in_array($day,[0,1,2])){
            //选择当天开始时间
            $beginTime  =   self::formatTime(mktime(0,0,0,date('m'),date('d')-$day,date('Y')));
            //选择当天结束时间
            $endTime    =   self::formatTime(mktime(0,0,0,date('m'),date('d')+1-$day,date('Y'))-1);
        }

        //获取本周起始时间
        if($day == 3){
            $beginTime  =   self::formatTime(mktime(0,0,0,date("m"),date("d")-date("w")-6,date("Y")));
            $endTime    =   self::formatTime(mktime(23,59,59,date("m"),date("d")-date("w"),date("Y")));
        }

        //php获取本月起始时间戳和结束时间戳
        if($day == 4){
            $beginTime  =   self::formatTime(mktime(0,0,0,date('m'),1,date('Y')));
            $endTime    =   self::formatTime(mktime(23,59,59,date('m'),date('t'),date('Y')));
        }

        //php获取本年起始时间戳和结束时间戳
        if($day == 4){
            $beginTime  =   self::formatTime(mktime(0,0,0,date('m'),1,date('Y')));
            $endTime    =   self::formatTime(mktime(23,59,59,date('m'),date('t'),date('Y')));
        }

        //获取前七天/三十天到今天的起始时间戳
        if(in_array($day,[7,30])){
            //选择当天开始时间
            $beginTime  =   self::formatTime(mktime(0,0,0,date('m'),date('d')-$day,date('Y')));
            //选择当天结束时间
            $endTime    =   self::formatTime(mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1);
        }

        return self::$time = [$beginTime,$endTime];
    }

    /**
     * 格式化时间
     * @param $time
     * @return false|string
     */
    public static function formatTime($time){
        return  date('Y-m-d H:i:s',$time);
    }

    /**
     * 获取时间结构
     * @param $start
     * @param $end
     * @param $data
     * @return array
     */
    public static function getTimeList($start,$end,$data){
        $collection = array();

        //循环计算
        while ($start <= $end) {

            $data['month'] = date('Y-m-d', $start);

            $collection[date('Y-m-d', $start)] = $data;

            $start = strtotime('+1 day', $start);
        }

        return $collection;
    }

    /**
     * 落地页折线图统计
     * @param $table
     * @param $select
     * @param $off
     * @param $start
     * @param $end
     * @param $channel_code
     * @param $store_id
     * @return \Illuminate\Database\Query\Builder
     */
    public static function getSellerQuData($table,$select,$off,$start,$end,$channel_code,$store_id){

        $query  =   DB::table($table." as w")->selectRaw($select)->where('w.shop_id',$store_id)->where('paid',1)->where('w.channel_code','like',"$channel_code%")->groupBy('datetime');

        //若是获取核销数量
        if($off)    $query->leftJoin('order_coupon as c','w.id','=','c.order_id')->where('w.status',4);

        //条件筛选 某时间段内
        if($start && $end){
            $start  =   date('Y-m-d 00:00:00',strtotime($start));
            $end    =   date('Y-m-d 23:59:59',strtotime($end));
            $query->whereBetween('w.created_at',[$start,$end]);
        }

        return $query;
    }

}
