<?php


namespace Tests\Mock;


use Tars\registry\contract\StoreCacheInterface;

class MemoryTable implements StoreCacheInterface
{
    private static $_instance;
    private $table = [];
    public function __construct($config)
    {

    }

    public static function getInstance()
    {
        return static::$_instance ?? static::$_instance = new static([]);
    }

    /**
     * set route info to cache.
     * @param $moduleName
     * @param $routeInfo
     * @return mixed
     */
    public function setRouteInfo($moduleName, $routeInfo)
    {
        $this->table[$moduleName] = [$routeInfo,time()];
    }

    /**
     * get route info by moduleName
     * @param $moduleName
     * @return mixed
     */
    public function getRouteInfo($moduleName)
    {
        if (!isset($this->table[$moduleName])) {
            return [];
        }
        $routeInfo = $this->table[$moduleName][0];
        $timestamp = $this->table[$moduleName][1];
        return [
            'routeInfo' => $routeInfo,
            'timestamp' => $timestamp,
        ];
    }
}
