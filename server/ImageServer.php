<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\server;

use app\server\curl\ImageCurl;
class ImageServer extends BaseServer
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
     * 创建一个镜像
     *
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function create()
    {
        
    }
    
    public function delete()
    {
        $aryResult = ImageCurl::server()->delete();
        print_r($aryResult);exit();
    }
}
