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
     * @param string $_strIp ip
     * @param string $_strRdsId rdsID
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
    
    /**
     * 查询审计sql日志
     * 
     * @param string $_strRdsId 实例ID
     * @param number $_intBeginTime 开始时间
     * @param number $_intEndTime 结束时间
     * @param number $_intPage 当前页数
     *
     * @author xiaoyi
     * @date 2016年11月2日
     */
    public function getSqlLog($_strRdsId="", $_intBeginTime=0, $_intEndTime=0, $_intPage=1)
    {
        date_default_timezone_set("Etc/GMT");
        $aryParam = [
                'DBInstanceId' => $_strRdsId,
                'StartTime' => date("Y-m-d", $_intBeginTime)."T".date("H:i:s", $_intBeginTime)."Z",
                'EndTime' => date("Y-m-d", $_intEndTime)."T".date("H:i:s", $_intEndTime)."Z",
                'PageSize' => 100,
                'PageNumber' => $_intPage
//                 'Form' => "File",
        ];
        $aryResult = $this->getResult("DescribeSQLLogRecords", $aryParam);
        date_default_timezone_set('Asia/Shanghai');
        return $aryResult;
    }
    
    /**
     * 日志
     * 
     * @param string $_strRdsId
     *
     * @author xiaoyi
     * @date 2016年11月3日
     */
    public function logFile($_strRdsId="")
    {
        $aryResult = $this->getResult("DescribeSQLLogFiles", ['DBInstanceId'=>$_strRdsId]);
        return $aryResult['Items']['LogFile'];
    }
}