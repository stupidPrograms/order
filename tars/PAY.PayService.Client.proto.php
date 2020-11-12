<?php
return array(
    'appName' => 'PAY',
    'serverName' => 'PayService',
    'objName' => 'PayTcp',
    'withServant' => false,//决定是服务端,还是客户端的自动生成
    'tarsFiles' => array(
        './PAY.PayService.tars'
    ),
    'dstPath' => '../src/app/Tars/cservant',
    'namespacePrefix' => 'App\Tars\cservant',
);