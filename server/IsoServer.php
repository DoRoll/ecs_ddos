<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\server;

class IsoServer extends BaseServer
{
    /**
     * 返回惟一实例
     *
     * @return IsoServer
     */
    public static function server( $className = __CLASS__ )
    {
        return parent::server($className);
    }
    
    /**
     * 创建一个镜像
     * 
     * @author xiaoyi
     * @date 2016年10月24日
     */
    public function create()
    {
    }
}
