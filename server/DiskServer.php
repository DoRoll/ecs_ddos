<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\server;

class DiskServer extends BaseServer
{
    /**
     * 返回惟一实例
     *
     * @return ImageServer
     */
    public static function server( $className = __CLASS__ )
    {
        return parent::server($className);
    }
    
    /**
     * 载入用户所有磁盘数据
     *
     * @author xiaoyi
     * @date 2016年10月26日
     */
    public function loadAllDisk()
    {
        
        
        
    }
}
