<?php
return array(
    'appName' => 'IntegralSystem',
    'serverName' => 'IntegralServer',
    'objName' => 'IntegralObj',
    'withServant' => false,//决定是服务端,还是客户端的自动生成
    'tarsFiles' => array(
        './IntegralSystem.IntegralServer.tars'
    ),
    'dstPath' => '../src/app/Tars/cservant',
    'namespacePrefix' => 'App\Tars\cservant',
);