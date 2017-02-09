<?php
namespace app\server\curl;

use app\server\curl\BaseCurl;
use Alidns\Request\V20150109\AddDomainRecordRequest;
use Ecs\Request\V20140526\DescribeDisksRequest;

class DiskCurl extends BaseCurl
{
    /**
     * 返回惟一实例
     *
     * @return DiskCurl
     */
    public static function server( $className = __CLASS__ )
    {
        return parent::server($className);
    }
    
    /**
     * 返回request实例
     *
     * @return \Ecs\Request\V20140526\DescribeRegionsRequest
     *
     * @author xiaoyi
     * @date 2016年10月21日
     */
    public function requestInstance()
    {
        return new DescribeDisksRequest();
    }
    
    
}