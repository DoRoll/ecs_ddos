<?php
namespace app\server\curl;

use app\server\curl\BaseCurl;
use DefaultProfile;
use DefaultAcsClient;
use Rds\Request\V20140815\DescribeRegionsRequest;
use Yii;
use app\exception\ErrorException;

class RdsCurl extends BaseCurl
{
    /**
     * 返回惟一实例
     *
     * @return RdsCurl
     */
    public static function server( $className = __CLASS__ )
    {
        return parent::server($className);
    }
    
    /**
     * 返回request实例
     * 
     * {@inheritDoc}
     * @see \app\server\curl\BaseCurl::requestInstance()
     * 
     * @author xiaoyi
     * @date 2016年10月21日
     */
    public function requestInstance()
    {
        return new DescribeRegionsRequest();
    }
    
    /**
     * 获取rds的ip列表
     * 
     * @param string $_strRdsId rdsId
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    public function getIpList($_strRdsId="")
    {
        $aryResult = $this->getResult("DescribeDBInstanceIPArrayList", ['DBInstanceId'=>$_strRdsId]);
        return $aryResult['Items']['DBInstanceIPArray'][0]['SecurityIPList'];
    }
    
    /**
     * 设置白名单IP
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    public function setIp($_strIp="", $_strRdsId="")
    {
        $aryParam = ['DBInstanceId'=> $_strRdsId, 'SecurityIps'=>$_strIp];
        $aryResult = $this->getResult("ModifySecurityIps", $aryParam);
        return true;
    }
}