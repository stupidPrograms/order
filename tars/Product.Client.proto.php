<?php
return array(
    'appName' => 'ProductTcp',
    'serverName' => 'ProductService',
    'objName' => 'ProductObj',
    'withServant' => false,//决定是服务端,还是客户端的自动生成
    'tarsFiles' => array(
        './Product.tars'
    ),
    'dstPath' => '../src/app/Tars/cservant',
    'namespacePrefix' => 'App\Tars\cservant',
);