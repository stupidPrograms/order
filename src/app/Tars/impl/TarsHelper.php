<?php


namespace App\Tars\impl;


//use Tars\core\Server;
//use Tars\core\TarsPlatform;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Tars\App;
use Tars\config\ConfigWrapper;
use Tars\Consts;
use Tars\monitor\cache\SwooleTableStoreCache;
use Tars\monitor\PropertyFServer;
use Tars\monitor\StatFServer;
use Tars\registry\QueryFWrapper;
use Tars\registry\RouteTable;
use Tars\report\ServerFSync;
use Tars\report\ServerFWrapper;
use Tars\report\ServerInfo;
use Tars\Utils;

class TarsHelper extends \App\Tars\Services\TarsHelper {}
