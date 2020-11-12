<?php


namespace App\Tars\Services;


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

class TarsHelper
{
    public static $env_in_tars = false;

    protected static $tarsConfig=[];

    protected static $tarsServerConfig;
    protected static $tarsClientConfig;

    protected static $sw;
    protected static $masterPidFile;
    protected static $managerPidFile;

    protected static $application;
    protected static $serverName = '';
    protected static $protocolName = 'http';

    protected static $workerNum = 4;

    protected static $setting;

    protected static $servicesInfo;
    protected static $paramInfos;
    protected static $namespaceName;
    protected static $executeClass;

    protected static $impl;
    protected static $protocol;
    protected static $timers;

    protected static $portObjNameMap = [];
    protected static $adapters = [];
    protected static $timerObjName = null;

    protected static $interval;
    protected static $statServantName;
    protected static $locator;
    protected static $moduleName;

    protected static $masterPid;

    protected static $tarsServer;

    public static function inTars(){
        return static::$env_in_tars;
    }

    /**
     * @return int
     */
    public static function getWorkerNum(): int
    {
        return self::$workerNum;
    }

    public static function getHttpAdatperName()
    {
        return static::getFullHttpObjName().'Adapter';
    }

    public static function getFullHttpObjName(){
        return static::getAppName().'.'.static::getServerName().'.'.static::getHttpObjName();
    }

    public static function getFullServiceName(){
        return static::getAppName().'.'.static::getServerName();
    }

    /**
     * @return mixed
     */
    public static function getAppName()
    {
        return self::$application;
    }

    /**
     * @return string
     */
    public static function getServerName(): string
    {
        return self::$serverName;
    }

    public static function getHttpObjName(){
        $httpAdapter = static::getTarsHttpAdapter();
        return $port = $httpAdapter['objName'];
    }


    /**
     * @return mixed
     */
    public static function getTarsConfig()
    {
        if (!self::$tarsConfig) {
            $options = getopt("",["config::"]);
            $config_path = $options["config"];
            self::setTarsConfig($config_path);
        }
        return self::$tarsConfig;
    }

    /**
     * 初始化
     * @param string $configPath
     */
    public static function init($configPath): void
    {
        static::setTarsConfig($configPath);
//        static::$tarsServer = new Server($conf);
        static::$masterPid = getmypid();
        static::initTarsApp();//设置TARS APP的上报

    }

    /**
     * @param string $configPath
     * @return array
     */
    public static function setTarsConfig($configPath)
    {
        static::$env_in_tars=true;

        $conf = self::$tarsConfig = Utils::parseFile($configPath);
        //初始化
        static::$tarsServerConfig = $conf['tars']['application']['server'];
        static::$tarsClientConfig = $conf['tars']['application']['client'];

        //不写services.php
//        static::$servicesInfo = static::$tarsServerConfig['servicesInfo'];

        static::$tarsConfig = $conf;
        static::$application = static::$tarsServerConfig['app'];
        static::$serverName = static::$tarsServerConfig['server'];

        static::$setting = static::$tarsServerConfig['setting'];

        if (isset(static::$tarsServerConfig['protocolName'])) {
            static::$protocolName = static::$tarsServerConfig['protocolName'];
        }

        static::$workerNum = static::$setting['worker_num'];
        static::$adapters = static::$tarsServerConfig['adapters'];

        //client信息
        static::$interval = static::$tarsClientConfig['report-interval'];
        static::$statServantName = static::$tarsClientConfig['stat'];
        static::$locator = static::$tarsClientConfig['locator'];
        static::$moduleName = static::$application . '.' . static::$serverName;

        return $conf;
    }

    public static function getTarsLocator(){
        $tarsConfig = static::getTarsConfig();
        return $tarsConfig['tars']['application']['client']['locator'] ?? null;
    }

    public static function getTarsHttpAdapter(){
        return isset(static::$adapters[0]) ? static::$adapters[0] : null;
    }

    public static function getLocalHttpIp(){
        $httpAdapter = static::getTarsHttpAdapter();
        return $httpAdapter['listen']['sIp'];

    }

    public static function getLocalHttpPort(){
        $httpAdapter = static::getTarsHttpAdapter();
        return $httpAdapter['listen']['iPort'];
    }

    /**
     * 返回servant对象
     * @param string $servantClassName
     * @param array $args
     * @return mixed
     */
    public static function servantFactory(string $servantClassName,...$args){
        if (empty($args)) {
            $vars = get_class_vars($servantClassName);
            $endpoint = $vars['_servantName'];
            list($appName,$serviceName,$objName)=explode('.',$endpoint,3);

            $config = new \Tars\client\CommunicatorConfig();

            $locator = static::getTarsLocator();

            $config->setLocator($locator);
            $config->setModuleName("$appName.$serviceName");
            $config->setCharsetName('UTF-8');
//            $config->setSocketMode(2); //1标识socket 2标识swoole同步 3标识swoole协程

            return new $servantClassName($config);
        } else {
            $ret = [static::servantFactory($servantClassName)];
            foreach ($args as $servantClassName) {
                $ret[] = static::servantFactory($servantClassName);
            }
            return $ret;
        }
    }

    /**
     * 定时上报存活
     */
    public static function setKeepAlive(){
        $masterPid = static::$masterPid;
        static::keepAlive($masterPid);
        //每隔30000ms触发一次
        //上报多个pid会被tars杀掉
        swoole_timer_tick(30000, function ($timer_id) use($masterPid){
            static::keepAlive($masterPid);
        });


    }

    protected static function keepAlive($masterPid = null)
    {
        $masterPid = $masterPid ?? static::$masterPid;
//        TarsPlatform::keepaliveInit(static::getTarsConfig(),$masterPid);
//        return;
        $application = static::getAppName();
        $serverName = static::getServerName();

        $adapter = static ::getHttpAdatperName();

        $masterPid = $masterPid ?? getmypid();

        $nodeInfo = static::getNodeInfo();
        if( empty($nodeInfo) ){
            var_dump('keepAlive getNodeInfo fail');
            return null;
        }
        $host = $nodeInfo['host'];
        $port = $nodeInfo['port'];
        $objName = $nodeInfo['objName'];

        $serverInfo = new ServerInfo();
        $serverInfo->adapter = $adapter;
        $serverInfo->application = $application;
        $serverInfo->serverName = $serverName;
        $serverInfo->pid = $masterPid;

        $serverF = new ServerFSync($host, $port, $objName);
        $serverF->keepAlive($serverInfo);

        $adminServerInfo = new ServerInfo();
        $adminServerInfo->adapter = 'AdminAdapter';
        $adminServerInfo->application = $application;
        $adminServerInfo->serverName = $serverName;
        $adminServerInfo->pid = $masterPid;
        $serverF->keepAlive($adminServerInfo);

//        var_dump('keepalive, master pid is '.$masterPid .'. ['. date('Y-m-d H:m:s.u'.']'));
    }

    public static function getNodeInfo()
    {
        $conf = static::getTarsConfig();
        if (!empty($conf)) {
            $node = $conf['tars']['application']['server']['node'];
            $nodeInfo = Utils::parseNodeInfo($node);
            return $nodeInfo;
        } else {
            return [];

        }
    }

    public static function initTarsApp()
    {
        $interval = static::$tarsClientConfig['report-interval'];
        $statServantName = static::$tarsClientConfig['stat'];
        $locator = static::$tarsClientConfig['locator'];
        $moduleName = static::$application . '.' . static::$serverName;


        // 日志组件初始化 根据平台配置的level来
        $logLevel = static::$tarsServerConfig['loglevel'];

        $logger = new Logger("tars_logger");

        $levelMap = [
            'DEBUG' => Logger::DEBUG,
            'INFO' => Logger::INFO,
            'NOTICE' => Logger::NOTICE,
            'WARNING' => Logger::WARNING,
            'ERROR' => Logger::ERROR,
            'CRITICAL' => Logger::CRITICAL,
        ];

        $levelNameMap = [
            'DEBUG' => 'log_debug.log',
            'INFO' => 'log_info.log',
            'NOTICE' => 'log_notice.log',
            'WARNING' => 'log_warning.log',
            'ERROR' => 'log_error.log',
            'CRITICAL' => 'log_critical.log',
        ];
        $loggerLevel = $levelMap[$logLevel];
        $loggerName = $levelNameMap[$logLevel];

        $outStreamHandler = new StreamHandler(
            static::$setting['log_file'], $loggerLevel
        );

        $levelStreamHandler = new StreamHandler(
            static::$tarsServerConfig['logpath'] . static::$tarsServerConfig['app'] . '/' .
            static::$tarsServerConfig['server'] . '/' . $loggerName, $loggerLevel
        );

        $logger->pushHandler($outStreamHandler);
        $logger->pushHandler($levelStreamHandler);


        $logger->info("stat/property/keepalive/config/logger service init start...\n");
        // 初始化被调上报
        $statF = new StatFServer($locator, Consts::SWOOLE_SYNC_MODE, $statServantName, $moduleName, $interval);

        $monitorStoreClassName =
            isset(static::$servicesInfo['monitorStoreConf']['className']) ?
                static::$servicesInfo['monitorStoreConf']['className'] :
                SwooleTableStoreCache::class;

        $monitorStoreConfig = isset(static::$servicesInfo['monitorStoreConf']['config'])
            ? static::$servicesInfo['monitorStoreConf']['config'] : [];

        $registryStoreClassName = isset(static::$servicesInfo['registryStoreConf']['className']) ? static::$servicesInfo['registryStoreConf']['className'] : RouteTable::class;
        $registryStoreConfig = isset(static::$servicesInfo['registryStoreConf']['config']) ? static::$servicesInfo['registryStoreConf']['config'] : [];

        $monitorStoreCache = new $monitorStoreClassName($monitorStoreConfig);
        $statF->initStoreCache($monitorStoreCache);

        $registryStoreCache = new $registryStoreClassName($registryStoreConfig);
        QueryFWrapper::initStoreCache($registryStoreCache);

        //初始化特性上报
        $propertyF = new PropertyFServer($locator, Consts::SWOOLE_SYNC_MODE,
            $moduleName);

        // 初始化服务保活
        // 解析出node上报的配置 tars.tarsnode.ServerObj@tcp -h 127.0.0.1 -p 2345 -t 10000
        $result = \Tars\Utils::parseNodeInfo(static::$tarsServerConfig['node']);
        $objName = $result['objName'];
        $host = $result['host'];
        $port = $result['port'];
        $serverF = new ServerFWrapper($host, $port, $objName);

        // 配置拉取初始化
        $configF = new ConfigWrapper(static::$tarsClientConfig);

        // 初始化
        App::setTarsConfig(static::$tarsConfig);
        App::setStatF($statF);
        App::setPropertyF($propertyF);
        App::setServerF($serverF);
        App::setConfigF($configF);
        App::setLogger($logger);

        $logger->info("stat/property/keepalive/config/logger service init finish...\n");
    }
}
