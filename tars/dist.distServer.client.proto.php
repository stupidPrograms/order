<?php
return array(
    'appName' => 'dist',
    'serverName' => 'distServer',
    'objName' => 'performanceObj',
    'withServant' => false,//决定是服务端,还是客户端的自动生成
    'tarsFiles' => array(
        './performance.tars'
    ),
    'dstPath' => '../src/app/Tars/cservant',
    'namespacePrefix' => 'App\Tars\cservant',
);