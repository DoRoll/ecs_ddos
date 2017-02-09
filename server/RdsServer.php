<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\server;

class RdsServer extends BaseServer
{
    /**
     * 返回惟一实例
     *
     * @return RdsServer
     */
    public static function server( $className = __CLASS__ )
    {
        return parent::server($className);
    }
}
