<?php

namespace app\server;

/**
 * server 基类
 * 
 * @author xiaoyi
 */
class BaseServer
{
    private static $_classServer = array();
    
    /**
     * 创建Server
     *
     * @param object $className
     * @return Server
     *
     * @author xiaoyi
     * @date 2015-07-04
     */
    public static function server($className = __CLASS__)
    {
        if(!isset(self::$_classServer[$className]))
            self::$_classServer[$className] = new $className();
        return self::$_classServer[$className];
    }
}