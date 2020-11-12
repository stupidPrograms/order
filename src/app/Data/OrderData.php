<?php


namespace App\Data;


use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderEvent;
use App\Models\OrderGoods;
use App\Models\OrderRecord;

use App\Services\OrderService;
use App\Tars\cservant\BB\UserService\User\UserServant;
use App\Tars\cservant\BB\UserService\User\classes\UserInfo;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\InUnify;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\OutUnify;
use App\Tars\cservant\PAY\PayService\PayTcp\classes\Status;
use App\Tars\cservant\PAY\PayService\PayTcp\PayServiceServant;
use App\Tars\cservant\BB\Product\ProductTcp\classes\AttrInfo;
use App\Tars\cservant\BB\Product\ProductTcp\classes\ProductInfo;
use App\Tars\cservant\BB\Product\ProductTcp\classes\StatusCode;
use App\Tars\cservant\BB\Product\ProductTcp\classes\UpdateData;
use App\Tars\cservant\BB\Product\ProductTcp\ProductServant;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\outMerchantInfo;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\resultMsg;
use App\Tars\cservant\BB\Shop\ShopTcp\classes\ShopInfo;
use App\Tars\cservant\BB\Shop\ShopTcp\ShopServant;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\orderCouponOut;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\outParam;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\updateOrderIdIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\classes\orderCouponIn;
use App\Tars\cservant\Coupon\CouponService\CouponTcp\CouponServant;
use App\Tars\impl\TarsHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Swoole\Timer;
use App\Models\OrderCoupon;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Tars\App;

class OrderData
{
    public $user,$uuid, $goods_num, $sku_id, $dist_code, $address_id,$env_domain_id,$openid,$store_id,$mobile,$orderType;

    /** @var AttrInfo */
    protected $attrInfo;

    /** @var ProductInfo */
    protected $product_info;

    protected $goods_id;
    protected $order_sn;
    //赠送积分
    protected $gift_points;
    //地址（长字符串）
    protected $address;
    //订单总价
    protected $orderPrice;
    //定金，需计算
    protected $deposit;
    //订单来源: 0. 其他 2.分销
    protected $order_source;
    //订单类型：1.在线订单；2.线下订单；
    protected $order_type;
    //线上需支付金额；
    protected $paidOnLine;
    //订单商品数据
    protected $order_data;
    //订单商品数据
    protected $order_goods_data;
    //订单过期时间
    protected $expiredTimeStamp;
    //订单类型，0位线上产品,1为核销产品
    protected $product_types;
    //优惠券id
    protected $coupon_id;

    protected $handCost;

    protected $saleCost;

    protected $couponServant;

    protected $couponInfo;

    //优惠券
    protected $couponData;
    //用户信息
    protected $userServant;

    protected $saleOrderData;

    protected $orderDate;
    protected $orderDates;

    /** @var ProductServant */
    protected $productServant;

    protected $ShopServant;


    /**
     * OrderData constructor.
     * @param null $user
     * @param string $uuid
     * @param int $good_id
     * @param int $goods_num
     * @param int $sku_id
     * @param string $dist_code
     * @param int $address_id
     * @param int $env_domain_id
     * @param string $openid
     * @param int $product_types
     * @param int $coupon_id
     * @param int $store_id
     * @param string $mobile
     * @param int $orderType
     */
    public function __construct(
        $user           =   null,
        $uuid           =   '',
        $good_id        =   0,
        $goods_num      =   0,
        $sku_id         =   0,
        $dist_code      =   '',
        $address_id     =   0,
        $env_domain_id  =   0,
        $openid         =   '',
        $product_types  =   0,
        $coupon_id      =   0,
        $store_id       =   0,
        $mobile         =   '',
        $orderType      =   2
    ){
        $this->user             =   $user;
        $this->uuid             =   $uuid;
        $this->goods_id         =   $good_id;
        $this->goods_num        =   $goods_num;
        $this->sku_id           =   $sku_id;
        $this->dist_code        =   $dist_code;
        $this->address_id       =   $address_id;
        $this->env_domain_id    =   $env_domain_id;
        $this->openid           =   $openid;
        $this->product_types    =   $product_types;
        $this->coupon_id        =   $coupon_id;
        $this->store_id         =   $store_id;
        $this->mobile           =   $mobile;
        $this->orderType        =   $orderType;
    }

    /**
     * 获取订单号
     * @return mixed
     */
    public function getOrderSn()
    {
        return $this->order_sn ?? $this->setOrderSn();
    }

    /**
     * 设置订单号
     * @return string
     */
    public function setOrderSn()
    {
        return $this->order_sn = date('YmdHis').rand(100000, 999999);
    }

    /**
     * 获取店铺系统服务
     * @return mixed
     */
    public function getShopServant()
    {
        return $this->ShopServant ?? $this->setShopServant();
    }

    /**
     * 设置店铺系统服务
     * @return mixed
     */
    public function setShopServant()
    {
        return $this->ShopServant = TarsHelper::servantFactory(ShopServant::class);
    }

    /**
     * 获取商品系统服务
     * @return ProductServant
     */
    public function getProductServant()
    {
        return $this->productServant ?? $this->setProductServant();
    }

    /**
     * 设置商品系统服务
     * @return mixed
     */
    public function setProductServant()
    {

         $this->productServant = TarsHelper::servantFactory(ProductServant::class);

        return  $this->productServant;
    }

    /**
     * 获取优惠券服务
     * @return mixed
     */
    public function getCoupon(){
        return $this->couponServant ?? $this->setCoupon();
    }

    public function setCoupon(){
        return $this->couponServant = TarsHelper::servantFactory(CouponServant::class);
    }

    /**
     * 获取用户系统服务配置
     * @return mixed
     */
    public function getUserServant(){
        return $this->userServant ??   $this->userServant = TarsHelper::servantFactory(UserServant::class);
    }

    /**
     * 判断手机号是否被注册过
     * @param $mobile
     * @return UserInfo
     */
    public static function getUserInfoByMobile($mobile){
        $userInfo       =   new UserInfo();
        $userServant    =   TarsHelper::servantFactory(UserServant::class);

        $userServant->getUserInfoByMobile($mobile,$userInfo);

        return $userInfo;
    }

    /**
     * 获取商品属性
     * @return AttrInfo
     * @throws \Exception
     */
    public function getAttrInfo(): AttrInfo
    {
        return $this->attrInfo ?? $this->setAttrInfo();
    }

    /**
     * 根据商品sku_id获取商品属性
     * @return AttrInfo
     * @throws \Exception
     */
    public function setAttrInfo()
    {
        var_dump('走到这里？');
        //获取产品属性
        $sku_id             = $this->sku_id;
        $product_servant    = $this->getProductServant();

        $attr_info = new AttrInfo();
        $product_servant->attribute($sku_id, $attr_info);

        if (!$attr_info->product_id) {
            var_dump("获取商品属性失败:".$attr_info->message);
            throw new BadRequestHttpException("获取商品属性失败:".$attr_info->message,null,$CodeData->code ?? 500);
        }
        var_dump($attr_info->code);
        var_dump($attr_info->message);
        var_dump($attr_info->name);
        return $this->attrInfo = $attr_info;
    }

    /**
     * 根据sku_id获取商品id
     * @return mixed
     * @throws \Exception
     */
    public function getGoodsId()
    {

        if($this->goods_id) return  $this->goods_id;

        return  $this->goods_id = $this->getAttrInfo()->product_id;
    }

    /**
     * 根据商品id获取商品详细信息
     * @return ProductInfo
     * @throws \Exception
     */
    public function getProductInfo(): ProductInfo
    {
        return $this->product_info ?? $this->setProductInfo();
    }

    /**
     * 获取商品详细信息
     * @return ProductInfo
     * @throws \Exception
     */
    public function setProductInfo()
    {
        var_dump('this is setProductInfo');
        //获取产品信息
        $goods_id           =   $this->getGoodsId();

        $product_servant    =   $this->getProductServant();


        $product_info = new ProductInfo();

        $product_servant->productdata($goods_id, $product_info);

        if($product_info->code != 200){
            var_dump("获取商品信息失败: ".$product_info->message);
            throw new  BadRequestHttpException("获取商品信息失败: ".$product_info->message,null,$CodeData->code ?? 500);
        }

        if (!$product_info->id) {
            var_dump("获取商品信息失败: ".$product_info->message);
            throw new  BadRequestHttpException("获取商品信息失败: ".$product_info->message);
        }

        return $this->product_info = $product_info;

    }

    /**
     * 获取店铺类型
     * @param int $store_id
     * @return ShopInfo
     * @throws \Exception
     */
    public function getShopInfo(){
        //获取店铺类型
        if(!$this->store_id){
            $store_id   = $this->getProductInfo()->store_id;
        }else{
            $store_id   =   $this->store_id;
        }

        $shopInfo   = new ShopInfo();
        $resultMsg  = new resultMsg();

        $this->getShopServant()->shopInfo($store_id,$resultMsg,$shopInfo);

        if($resultMsg->code != 200){
            var_dump('店铺数据错误 ： '.$resultMsg->msg);
            throw new BadRequestHttpException('店铺数据错误 ： '.$resultMsg->msg);
        }

        return  $shopInfo;
    }

    /**
     * 获取地址
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address ?? $this->setAddress();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function setAddress()
    {
        $model = OrderAddress::query()->where('id',$this->address_id)->where('uuid',$this->uuid)->firstOrFail();
        return $this->address = $model;
    }

    /**
     * 订单来源
     * @return mixed
     */
    public function getOrderSource()
    {
        return $this->order_source ?? $this->setOrderSource();
    }

    /**
     * @return int
     */
    public function setOrderSource()
    {
        $dist_code      =   $this->dist_code;
        $order_source   =   0;

        if ($dist_code){
            $order_source = 2;
        }

        return $this->order_source = $order_source;
    }


    /**
     * 获取商品的价格
     * @return float|int
     * @throws \Exception
     */
    public function getOrderPrice()
    {
        return $this->orderPrice ?? $this->setOrderPrice();
    }

    /**
     * @return float|int
     * @throws \Exception
     */
    public function setOrderPrice()
    {
        if($this->sku_id){
            var_dump('kkkkkkkkkk');
            var_dump($this->sku_id);
            $orderPrice = $this->goods_num * $this->getAttrInfo()->price;

        }else{
            $orderPrice = $this->goods_num * $this->getProductInfo()->price;
        }

        return $this->orderPrice = $orderPrice;
    }

    /**
     * 获取支付金额
     * @return float|int
     * @throws \Exception
     */
    public function getPaidOnLine()
    {
        return $this->paidOnLine ?? $this->setPaidOnLine();
    }

    /**
     * 计算支付金额(计算使用优惠券等一系列后的应付金额)
     * @return float|int
     * @throws \Exception
     */
    public function setPaidOnLine()
    {
        //支付整个订单
        $_paidOnLine = $this->getOrderPrice();

        if($this->coupon_id){
            $paidOnLine = $this->couponPrice($_paidOnLine);

        }else{
            $paidOnLine = $_paidOnLine;
        }

        return $this->paidOnLine = $paidOnLine;
    }

    /**
     * 执行优惠券使用计划
     * @param $_paidOnLine
     * @param int $is_check
     * @return float|int
     * @throws \Exception
     */
    public function couponPrice($_paidOnLine,$is_check = 1){

        //获取订单优惠券信息
        $this->getCouponInfo($_paidOnLine,$is_check);

        //若amount不为0，则为折扣卷
        if($this->couponInfo['amount']){
            //最终金额
            $paidOnLine = $_paidOnLine * $this->couponInfo['amount'] / 100;

            return $paidOnLine;

        }else{
            //定金劵和满减劵
            $red_money = $this->couponInfo['reduction_money'];

            //判断满减券或者定金券金额，若大于商品/订单金额，则支付0
            if($red_money > $_paidOnLine){
                return $paidOnLine = 0;
            }else{
                $paidOnLine = $_paidOnLine - $this->couponInfo['reduction_money'];
                return  $paidOnLine;
            }

        }
    }

    /**
     * 获取订单优惠券信息
     * @param $money
     * @param $is_check
     * @return mixed
     * @throws \Exception
     */
    public function getCouponInfo($money,$is_check)
    {
        //获取用户信息
        $userInfo = $this->getUserInfo($this->uuid,$this->env_domain_id);

        $orderCouponOut     = new orderCouponOut();
        $orderCouponIn      = new orderCouponIn();

        if(!$userInfo->nickname){
            $userInfo->nickname = 'N/A';
        }

        //获取店铺信息，若初始化店铺为0，则需要获取一次（用于核销）
        $shop_id = $this->store_id;
        if($shop_id == 0){
            $shop_id =  $this->getProductInfo()->store_id;
        }

        $orderCouponIn->name        =   $userInfo->nickname;
        $orderCouponIn->mobile      =   $userInfo->mobile;
        $orderCouponIn->coupon_id   =   $this->coupon_id;
        $orderCouponIn->money       =   $money;
        $orderCouponIn->order_sn    =   $this->getOrderSn();
        $orderCouponIn->goods_id    =   $this->goods_id;
        $orderCouponIn->shop_id     =   $shop_id;
        $orderCouponIn->is_check    =   $is_check;

        var_dump('ppppppppppppppppppppppp');
        var_dump($userInfo->nickname);
        var_dump($userInfo->mobile);
        var_dump($this->coupon_id);
        var_dump($money);
        var_dump($this->getOrderSn());
        var_dump($this->goods_id);
        var_dump($shop_id);
        var_dump($is_check);

        $couponServant = $this->getCoupon();
        $couponServant->orderCouponInfo($orderCouponIn,$orderCouponOut);

        if($orderCouponOut->code != 200){
            throw new BadRequestHttpException($orderCouponOut->message);
        }

        return $this->couponInfo = $orderCouponOut->coupon_info[0];
    }

    /**
     * 获取用户信息
     * @param $uuid
     * @param $domainId
     * @return UserInfo
     */
    public function getUserInfo($uuid,$domainId){
        $userInfo   = new userInfo();
        $error      = '';
        $this->getUserServant()->getUserInfoByUuid($uuid,$domainId,$userInfo,$error);

        return $userInfo;
    }

    /**
     * 初始化订单数据
     * @param null $code
     * @param int $pay_online
     * @param null $channel_code
     * @param null $poster_code
     * @param null $store_mobile
     * @return array
     * @throws \Exception
     */
    public function getOrderData($code = null,$pay_online = 0,$channel_code = null,$poster_code = null,$store_mobile = null)
    {
        return $this->order_data ?? $this->setOrderData($code,$pay_online,$channel_code,$poster_code,$store_mobile);
    }

    /**
     * 设置订单数据
     * @param $code
     * @param $pay_online
     * @param null $channel_code
     * @param null $poster_code
     * @param null $store_mobile
     * @return array
     * @throws \Exception
     */
    public function setOrderData($code,$pay_online,$channel_code,$poster_code,$store_mobile)
    {
        //创建订单原始数据
        $userInfo   =   $this->user;
        $recipient  =   $userInfo['recipient'];
        $phone      =   $userInfo['phone'];
        $province   =   'N/A';

        if($this->address_id){
            $address    = $this->getAddress();
            $recipient  = $address['recipient'];
            $phone      = $address['phone'];
            //收货地址拼接
            $province   = $address['province'].$address['city'].$address['area'].$address['address'];
        }

        //获取手续费费率
        list($hand,$co) = $this->getHandCost(99,$pay_online);


        $order_data = [
            'ordersn'           =>  $this->getOrderSn(),
            'order_type'        =>  $this->orderType,
            'uuid'              =>  $this->uuid,
            'shop_id'           =>  $this->getProductInfo()->store_id,
            'money'             =>  $this->getOrderPrice(),
            'dist_code'         =>  $this->dist_code,
            'recipient'         =>  $recipient,
            'phone'             =>  $phone,
            'address'           =>  $province,//收货地址拼接
            'create_by_phone'   =>  $userInfo['phone'],
            'order_source'      =>  $this->getOrderSource(),
            'pay_online'        =>  $this->getPaidOnLine(),
            'env_domain_id'     =>  $this->env_domain_id,
            'openid'            =>  $this->openid,
            'store_mobile'      =>  $this->mobile,
            'business_id'       =>  $this->getShopInfo()->uid,
            'hand_rate'         =>  $hand,
            'hand_cost'         =>  $co,
        ];

        //若存在拼团code,则记录拼团信息
        if($code)           $order_data['group_code']   =   $code;

        //联系商家的手机号，用于拼团秒杀
        if($store_mobile)   $order_data['store_mobile'] =   $store_mobile;

        //若存在秒杀code,则记录秒杀信息
        if($channel_code)  $order_data['channel_code']  =   $channel_code;
        if($poster_code)   $order_data['poster_code']   =   $poster_code;

        //若是拼团或者秒杀，则覆盖新的价格
        if($pay_online)     $order_data['pay_online']   =   $pay_online;

        return $this->order_data = $order_data;
    }

    /**
     *  获取手续费费率
     * @param $status
     * @param int $money
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getHandCost($status,$money = 0){
        return $this->handCost ?? $this->handCost = $this->setHandCost($status,$money);
    }

    /**
     * 设置手续费费率
     * @param $status
     * @param $money
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setHandCost($status,$money){

        //1:邦邦/邦部落-专业版 2邦部落-试用  3邦部落-普通版
        $type       =   $this->getShopInfo()->version_type;

        //获取手续费设置
        $inteRate   =   $this->inteRate();

        //支付金额

        if($money == 0)   $money = $this->getPaidOnLine();


        //抽佣比例
        $hand = 0;

        //抽佣积分
        $co = 0;

        //专业版
        if($type ==  1){
            //默认线上订单手续费率
            $hand   =   $inteRate['professional_merc_order_rate'];

            //虚拟订单手续费率
            if($status == -5){
                $hand   =   $inteRate['professional_merc_offline_order_rate'];
                $co     =   floor($money * $hand * 20) / 100;
            }else{
                //正常线上订单手续费
                $co     =   floor($money * $hand * 20) / 100;
            };

        }

        //普通版
        if($type == 3){
            //默认线上订单手续费率
            $hand   =   $inteRate['ordinary_merc_order_rate'];

            //虚拟订单手续费率
            if($status == -5){
                $hand   =   $inteRate['ordinary_merc_offline_order_rate'];
                $co     =   floor($money * $hand * 20) / 100;
            }else{
                //正常线上订单手续费
                $co     =   floor($money * $hand * 20) / 100;
            }

        }
        return [$hand,$co];
    }


    /**
     * 获取积分手续设置
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

            return   $bodyStr['data'];

        }catch (\Exception $e){
            throw new BadRequestHttpException($e->getMessage().':'.$e->getLine());
        }
    }

    /**
     * 订单创建
     * @return mixed
     * @throws \Exception
     */
    public function getOrderGoodsData()
    {
        return $this->order_goods_data ?? $this->setOrderGoodsData();
    }

    /**
     * 订单创建
     * @return mixed
     * @throws \Exception
     */
    public function setOrderGoodsData()
    {
        try {
            DB::beginTransaction();
            $orderGoods = (function () {

                $order = Order::query()->create($this->getOrderData());

                if (!$order) {
                    DB::rollBack();
                    throw new BadRequestHttpException("订单创建失败");
                }

                //获取商品详细信息
                $order_goods_data = $this->getOrderGoodsInfo($order['id']);

                //记录商品信息
                $orderGoods = OrderGoods::query()->create($order_goods_data);

                //若使用优惠券，则记录优惠券信息
                if($this->coupon_id){

                    //这里根据订单号，给优惠券系统添加订单id
                    $out = $this->doAddId($order['id']);
                    if($out->code != 200){
                        DB::rollBack();
                        throw new BadRequestHttpException("优惠券订单创建失败C:".$out->message);
                    }

                    //优惠券数据设置
                    $couponData                 =   $this->getCouponData();
                    $couponData['order_id']     =   $order['id'];

                    $set = OrderCoupon::query()->insert($couponData);
                    if(!$set){
                        DB::rollBack();
                        throw new BadRequestHttpException("优惠券订单创建失败:数据插入错误");
                    }

                    //修改优惠券状态
                    $out = OrderService::editCoupon($this->getOrderSn(),1);
                    if($out->code != 200){
                        DB::rollBack();
                        throw new BadRequestHttpException("优惠券订单创建失败D:".$out->message);
                    }

                }

                //记录订单信息
                $this->addOrderInfo($order['id'],$order['recipient'],$order['phone']);
                DB::commit();

                return $orderGoods;
            })();

            if ($orderGoods) {
                //订单操作
                OrderEvent::setEvent($this->getOrderSn(), OrderEvent::ORDER_CREATED);
                DB::commit();
                return $this->order_goods_data = $orderGoods;
            }

        } catch (\Exception $e) {
            DB::rollBack();
            var_dump($e->getMessage().$e->getTraceAsString());
        }
        DB::rollBack();
        throw new \Exception($e->getMessage().$e->getTraceAsString());
    }

    /**
     * 获取商品详细信息
     * @param $order_id
     * @return array
     * @throws \Exception
     */
    public function getOrderGoodsInfo($order_id){

        $sku_id             =   $this->sku_id;
        $product_info       =   $this->getProductInfo();

        if($sku_id){
            $attr_info      =   $this->getAttrInfo();
            $attr_name      =   $attr_info->name;
            $price          =   $attr_info->price;
            $cost           =   (int)$attr_info->cost;
        }else{
            $attr_name      =   'N/A';
            $price          =   $product_info->price;
            $cost           =   0;
        }

        $order_goods_data   = [
            'order_id'      =>  $order_id,
            'shop_id'       =>  $product_info->store_id,
            'goods_id'      =>  $product_info->id,
            'goods_name'    =>  $product_info->name,
            'sku_id'        =>  $sku_id,
            'thumb'         =>  $product_info->thumb,
            'attr_name'     =>  $attr_name,
            'price'         =>  $price,
            'num'           =>  $this->goods_num,
            'ordersn'       =>  $this->getOrderSn(),
            'cost'          =>  $cost,
        ];

        return $order_goods_data;
    }

    /**
     * 记录订单信息
     * @param $orderId
     * @param $recipient
     * @param $phone
     */
    public function addOrderInfo($orderId,$recipient,$phone){
        $data = date('Y-m-d H:i:s');
        //记录操作信息
        $data = [
            'order_id'      =>  $orderId,
            'operator'      =>  $recipient,
            'mobile'        =>  $phone,
            'record_type'   =>  1,
            'comment'       =>  '提交了订单',
            'mark'          =>  '提交了订单',
            'created_at'    =>  $data,
            'updated_at'    =>  $data,

        ];
        OrderRecord::query()->insert($data);
    }

    /**
     * 根据订单号，给优惠券系统添加订单id
     * @param $order_id
     * @return outParam
     */
    public function doAddId($order_id){

        $outParam        = new outParam();
        $updateOrderIdIn = new updateOrderIdIn();

        $updateOrderIdIn->order_id  =   $order_id;
        $updateOrderIdIn->order_sn  =   $this->getOrderSn();
        $updateOrderIdIn->uuid      =   $this->uuid;

        $couponServant  =   $this->getCoupon();
        $couponServant->updateOrderId($updateOrderIdIn,$outParam);

        return $outParam;
    }

    /**
     * 优惠券数据设置(记录优惠券信息)
     * @throws \Exception
     */
    public function getCouponData(){
        return $this->couponData ?? $this->couponData = $this->setCouponData();
    }

    /**
     * 优惠券数据设置
     * @return array
     * @throws \Exception
     */
    public function setCouponData(){

        $shop_id    =   $this->store_id;
        $goods_id   =   0;

        if($shop_id == 0){
            $shop_id        =   $this->getProductInfo()->store_id;
            $product_info   =   $this->getProductInfo();
            $goods_id       =   $product_info->id;
        }


        $coupon_data = [
            'shop_id'           =>  $shop_id,
            'goods_id'          =>  $goods_id,
            'coupon_id'         =>  $this->coupon_id,
            'coupon_name'       =>  $this->couponInfo['coupon_name'],
            'amount'            =>  $this->couponInfo['amount'] ?? $this->couponInfo['reduction_money'],
            'coupon_type'       =>  $this->couponInfo['coupon_type'],
            'reduction_money'   =>  $this->couponInfo['reduction_money'],    //减免金额
            'content'           =>  $this->couponInfo['content'],
            'start_time'        =>  $this->couponInfo['start_time'],
            'end_time'          =>  $this->couponInfo['end_time'],
            'domain_id'         =>  $this->env_domain_id,
            'created_at'        =>  date('Y-m-d H:i:s'),
            'updated_at'        =>  date('Y-m-d H:i:s')
        ];

        return $coupon_data;
    }

    /**
     * 确保库存已经扣除，实际上应该库存系统提供接口确认
     * @return bool
     * @throws \Exception
     */
    public function ensureStockIsDeducted()
    {
        $status = OrderEvent::getStatus($this->getOrderSn());
        switch ($status) {
            case OrderEvent::ORDER_CREATED:
                $stock_data             =   new UpdateData();
                $stock_data->id         =   $this->goods_id;
                $stock_data->attr_id    =   $this->sku_id;
                $stock_data->num        =   $this->goods_num;
                $stock_data->type       =   0;
                $stock_data->order_id   =   $this->getOrderModel()->id;
                $stock_data->remarks    =   "订单 sn:".$this->getOrderSn()."下单扣除库存";

                $CodeData = new StatusCode();
                $product_servant = $this->getProductServant();

                $product_servant->updateStock($stock_data, $CodeData);

                if ($CodeData->code !=200){
                    throw new BadRequestHttpException('商品库存数量不足',null,$CodeData->code ?? 500);
                }

                OrderEvent::setEvent($this->getOrderSn(),OrderEvent::STOCK_DEDUCTED);
                return true;
            default:
                return true;
        }
    }

    /**
     * 创建支付订单
     * @return bool
     * @throws \Exception
     */
    public function ensurePaymentOrderIsCreated()
    {
        try{
            $status = 1;
            switch ($status) {
                case OrderEvent::STOCK_DEDUCTED:

                    $store_id       = $this->getProductInfo()->store_id;


                    $shopInfo  = new ShopInfo();
                    $resultMsg = new resultMsg();
                    $this->getShopServant()->shopInfo($store_id,$resultMsg,$shopInfo);

                    $merchantResultData = new resultMsg();
                    $merchantInfo       = new outMerchantInfo;

                    $in_unify           =   new InUnify();
                    $in_unify->uuid     =   $this->uuid;
                    $in_unify->storeId  =   (string)$store_id;
                    $in_unify->mark     =   'buyProduct';
                    $product_info       =   $this->getProductInfo();

                    if($this->sku_id){
                        $attr_info      =   $this->getAttrInfo();
                        $remark         =   '购买商品'. $product_info->name. $attr_info->name;
                    }else{
                        $remark         =   '购买商品'. $product_info->name;
                    }

                    $in_unify->remark   =   $remark;

                    //线上支付价格X100（因为支付系统单位是分）
                    $money  =   $this->getOrderModel()->pay_online;

                    var_dump(2.3 * 100);
                    var_dump(\bcmul(2.3,100,2));
                    var_dump('--------');
                    var_dump(2.28 * 100);
                    var_dump(\bcmul(2.28,100,2));
                    var_dump('-----------');
                    var_dump(\bcmul($money,100,2));

                    $in_unify->amount   =   \bcmul($money,100,2);

                    $in_unify->orderSn  =   $this->getOrderSn();
                    $in_unify->doMainId =   $this->env_domain_id;

                    //获取店铺商户号
                    $this->getShopServant()->getMerchantInfo($store_id,$merchantResultData, $merchantInfo);
                    $in_unify->merchantNo = $merchantInfo->merchant_number;

                    //过期时间戳
                    $timestamp          = time()+(60*60);

                    //秒杀订单设置过期时间
                    if($this->orderType == 4)    $timestamp   = time()+(60*10);

                    $this->setExpiredTimeStamp($timestamp);
                    $over_time          = Carbon::createFromTimestamp($timestamp)->toDateTimeString();

                    $in_unify->validat  = $over_time;
                    $pay_status         = new Status();
                    $pay_out_unify      = new OutUnify();
                    var_dump(888888888);
                    //创建支付单号
                    $pay_servant    = TarsHelper::servantFactory(PayServiceServant::class);
                    $pay_servant->unify($in_unify, $pay_status, $pay_out_unify);
                    var_dump('kkkkkkkkkkkkkkkkk');
                    var_dump($pay_status->code);
                    var_dump($pay_status->msg);
                    var_dump($pay_status->err);
                    var_dump('鸡儿鸡儿');
                    if ($pay_status->err){
                        throw new BadRequestHttpException('支付系统错误'.$pay_status->msg);
                    }

                    OrderEvent::setEvent($this->getOrderSn(),OrderEvent::ORDER_UNPAID);

                //这里不用break,因为考虑到可以重入
                case OrderEvent::ORDER_UNPAID:

                    //支付单号创建成功后，更新订单信息
                    //$order = $this->getOrderModel();

                    $Orderdata = ['pay_ordersn' => $pay_out_unify->ordersn, 'over_time' => $timestamp,'status'=>0];

                    //自提为待核销状态
                    if($this->address_id == 0)  $Orderdata['sale_code'] =   substr(uniqid(),7);

                    order::updateOrder($Orderdata, $this->getOrderSn(), '') ;
                    return true;
                default:
                    return true;


            }
        }catch (\Exception $e){
            var_dump($e->getMessage());
            throw new BadRequestHttpException('支付系统错误'.$pay_status->msg);
        }

    }

    public function getOrderModel()
    {
        $orderSn = $this->getOrderSn();
        return $this->orderDate ?? ($this->orderDate = Order::query()->where('ordersn',$orderSn)->firstOrFail());
    }

    public function getOrderModels()
    {
        $orderSn = $this->getOrderSn();
        return $this->orderDates ?? $this->orderDates =  Order::query()->where('ordersn',$orderSn)->firstOrFail();
    }

    /**
     * 定时关闭正常商品订单
     * @throws \Exception
     */
    public function deferCheckAndCloseUnpaidOrder()
    {
        //支付金额为0，不做定时操作
        if($this->getPaidOnLine() == 0) return;

        //定时关闭订单 60分钟未支付关闭
        $ordersn            =   $this->getOrderSn();
        $sku_id             =   $this->sku_id;
        $goods_num          =   $this->goods_num;
        $product_servant    =   $this->getProductServant();
        $order              =   $this->getOrderModels();


        //默认为60分钟
        $time   =   1000*60*60;

        //若是秒杀订单，则为10分钟
        if($order->order_type == 4) $time   =   1000*60*10;

        Timer::after($time,function() use ($ordersn,$sku_id, $goods_num, $product_servant){

            $order              =   Order::query()->where('ordersn',$ordersn)->firstOrFail();

            //若是拼团订单/秒杀订单，跳过库存回滚
            if($order->order_type != 4 && $order->order_type != 5 ){
                //订单未支付，过期  类型数据正常订单
                if ($order->paid == 0 && $order->status == 0) {

                    $stock_data = new UpdateData();
                    $stock_data->id         =   $this->goods_id;
                    $stock_data->attr_id    =   $sku_id;
                    $stock_data->num        =   $goods_num;
                    $stock_data->type       =   1;//库存更改类型为退货
                    $stock_data->order_id   =   $this->getOrderModel()->id;
                    $stock_data->remarks    =   "订单sn: " . $this->getOrderSn() . "超时未支付关闭，库存增加";

                    $CodeData = new StatusCode();
                    $product_servant->updateStock($stock_data, $CodeData);


                    //修改优惠券状态
                    $out = OrderService::editCoupon($this->getOrderSn(), 3);

                    if ($CodeData->code != 200 || $out->code != 200) {
                        Log::info('订单号:' . $ordersn . '; sku_id:' . $sku_id . '; 数量:' . $goods_num . '; ' . $CodeData->message);
                    }

                }
            }

            //秒杀订单通知秒杀系统做库存回滚
            if($order->order_type == 4 && $order->status == 0)    OrderService::doCallbackNotify($ordersn,-2);

            //订单关闭
            Order::query()->where('ordersn',$ordersn)->where('paid',0)->update(['status' => -2]);

        });
        OrderEvent::setEvent($this->getOrderSn(),OrderEvent::ORDER_CLOSED);
    }


    /**
     * @return mixed
     */
    public function getExpiredTimeStamp()
    {
        return $this->expiredTimeStamp;
    }

    /**
     * @param mixed $expiredTimeStamp
     */
    public function setExpiredTimeStamp($expiredTimeStamp): void
    {
        $this->expiredTimeStamp = $expiredTimeStamp;
    }






    /**
     * 初始化核销订单数据
     * @param $money
     * @param $shop_id
     * @param $domain_id
     * @param $phone
     * @param $create_by_phone
     * @return array
     * @throws \Exception
     */
    public function setSaleOrderData($money,$shop_id,$domain_id,$phone,$create_by_phone){

        //获取手续费费率
        list($hand,$co) =   $this->getHandCost(-5,$money);
        $pay_money      =   $this->getSalePrice($money);

        return $this->saleOrderData = [
            'ordersn'           =>  $this->getOrderSn(),
            'uuid'              =>  $this->uuid,
            'order_type'        =>  6,
            'shop_id'           =>  $shop_id,
            'money'             =>  $money,
            'business_id'       =>  $this->getShopInfo()->uid,
            'pay_online'        =>  $pay_money,
            'pay_offline'       =>  $pay_money,
            'surplus_money'     =>  $pay_money,
            'recipient'         =>  'N/A',
            'address'           =>  'N/A',
            'express_code'      =>  'N/A',
            'phone'             =>  $phone,
            'create_by_phone'   =>  $create_by_phone,
            'order_source'      =>  3,
            'env_domain_id'     =>  $domain_id,
            'sale_code'         =>  substr(uniqid(),7),
            'status'            =>  -5,
            'remark'            =>  '线下核销虚拟订单',
            'hand_cost'         =>  $co,
            'hand_rate'         =>  $hand,
        ];
    }

    /**
     * 使用优惠券 , 计算订单的价格
     * @param $money
     * @return float|int
     * @throws \Exception
     */
    public function getSalePrice($money){
        var_dump('oooooopp');
        var_dump($money);
        var_dump($this->uuid);
        var_dump($this->coupon_id);

        if($this->uuid && $this->coupon_id){

            //优惠券金额计算
            $money = $this->couponPrice($money,2);
        }
        return $money;

    }

    /**
     * 核销订单数据入库
     */
    public function createSaleOrderData()
    {
        try {
            DB::beginTransaction();
            //数据入库
            $order = Order::query()->create($this->saleOrderData);
            if (!$order) {
                DB::rollBack();
                throw new BadRequestHttpException("订单创建失败");
            }

            //核销商品信息
            $order_goods_data   = [
                'order_id'      =>  $order['id'],
                'shop_id'       =>  $this->store_id,
                'goods_id'      =>  0,
                'goods_name'    =>  '核销虚拟订单',
                'sku_id'        =>  0,
                'thumb'         =>  'N/A',
                'attr_name'     =>  'N/A',
                'price'         =>  $order['money'],
                'num'           =>  1,
                'ordersn'       =>  $this->getOrderSn(),
                'cost'          =>  0,
            ];

            //记录商品信息
            $orderGoods = OrderGoods::query()->create($order_goods_data);
            if (!$orderGoods) {
                DB::rollBack();
                throw new BadRequestHttpException("核销信息创建失败");
            }

            $make = "商家创建虚拟订单";
            $addRecord = OrderService::addOrderRecord($order['id'],'管理员',$order['phone'],4,$make);

            if (!$addRecord) {
                DB::rollBack();
                throw new BadRequestHttpException("订单备注填写失败");
            }

            //若使用优惠券，则记录优惠券信息
            if($this->uuid && $this->coupon_id){

                //这里根据订单号，给优惠券系统添加订单id
                $out = $this->doAddId($order['id']);
                if($out->code != 200){
                    DB::rollBack();
                    throw new BadRequestHttpException("优惠券订单创建失败A:".$out->message);
                }

                //初始化优惠券数据
                $couponData                 =   $this->getCouponData();
                $couponData['order_id']     =   $order['id'];

                $set = OrderCoupon::query()->insert($couponData);
                if(!$set){
                    DB::rollBack();
                    throw new BadRequestHttpException("优惠券订单创建失败:数据插入错误");
                }

                //修改优惠券状态
                $out = OrderService::editCoupon($this->getOrderSn(),1);
                if($out->code != 200){
                    DB::rollBack();
                    throw new BadRequestHttpException("优惠券订单创建失败B:".$out->message);
                }

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            //var_dump($e->getMessage().$e->getTraceAsString().$e->getLine());
            App::getLogger()->error($e->getMessage().$e->getFile());
            throw new BadRequestHttpException("订单创建失败");
        }
    }

    /**
     * 虚拟商品创建支付订单
     */
    public function ensurePaySaleOrder()
    {
        try{
            //创建支付单号
            $payServant    = TarsHelper::servantFactory(PayServiceServant::class);

            //获取店铺信息，若初始化店铺为0，则需要获取一次（用于核销）
            $shop_id = $this->store_id;

            $in_unify           =   new InUnify();

            $in_unify->storeId  =   $shop_id;
            $in_unify->mark     =   'saleBuyProduct';
            $in_unify->remark   =   '购买虚拟商品商品';



            $in_unify->orderSn  =   $this->getOrderSn();
            $in_unify->doMainId =   $this->env_domain_id;

            $in_unify->amount   =   $this->getOrderModel()->pay_offline * 100; //线上支付价格X100（因为支付系统单位是分）

            if($this->uuid){ $in_unify->uuid   =   $this->uuid; }else{$in_unify->uuid = '00000000000000';}

            $pay_status     = new Status();
            $pay_out_unify  = new OutUnify();

            $payServant->unify($in_unify, $pay_status, $pay_out_unify);

            if ($pay_status->err){
                throw new BadRequestHttpException('支付系统错误 : '.$pay_status->msg);
            }

        }catch (\Exception $e){
            var_dump($e->getMessage());
            throw new BadRequestHttpException("支付系统错误 ： ".$pay_status->msg);
        }
    }






    /**
     * 拼团 / 秒杀订单创建
     * @return mixed
     * @throws \Exception
     */
    public function createSeckOrder(){
        try {
            DB::beginTransaction();
            $orderGoods = (function () {
                $order = Order::query()->create($this->getOrderData());
                if (!$order) {
                    DB::rollBack();
                    throw new BadRequestHttpException("订单创建失败");
                }

                //获取商品详细信息
                $order_goods_data = $this->getOrderGoodsInfo($order['id']);

                //记录商品信息
                $orderGoods = OrderGoods::query()->create($order_goods_data);

                //记录订单信息
                $this->addOrderInfo($order['id'],$order['recipient'],$order['phone']);
                DB::commit();
                return $orderGoods;
            })();

            if ($orderGoods) {
                OrderEvent::setEvent($this->getOrderSn(), OrderEvent::ORDER_CREATED);
                DB::commit();
                return $this->order_goods_data = $orderGoods;
            }

        } catch (\Exception $e) {
            DB::rollBack();
            var_dump($e->getMessage());
        }
        DB::rollBack();
        throw new \Exception($e->getMessage().$e->getTraceAsString());

    }

}
