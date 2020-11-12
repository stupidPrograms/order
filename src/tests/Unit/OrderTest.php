<?php

namespace Tests\Unit;

use App\Services\OrderService;
use App\Tars\Services\TarsHelper;
use Tars\registry\QueryFWrapper;
use Tests\Mock\MemoryTable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $configFile = __DIR__."/../../../conf/OrderSystem.OrderServer.config.conf";
        TarsHelper::setTarsConfig($configFile);
        $table = new MemoryTable([]);
        QueryFWrapper::initStoreCache($table);
//        $SERVER['argv'][]=$argv[] = "--config=".$configFile;
    }

    /**
     * @throws \Exception
     */
    public function testExample()
    {
        $obj = OrderService::createOrder("0bb5ea9ed2444a77a9f94e0f5caa74cc",1,1947,"",70,"shop.bangsales.com");
        $paymentOrder = $obj->getPaymentOrder();
        $this->assertTrue($paymentOrder);
    }
}
