<?php
return array(
    'appName' => 'BB',
    'serverName' => 'UserService',
    'objName' => 'User',
    'withServant' => false,//决定是服务端,还是客户端的自动生成
    'tarsFiles' => array(
        './BB.UserService.User.tars'
    ),
    'dstPath' => '../src/app/Tars/cservant',
    'namespacePrefix' => 'App\Tars\cservant',
);