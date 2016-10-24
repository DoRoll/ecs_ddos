<?php
namespace app\server\curl;

use app\server\curl\BaseCurl;
use Alidns\Request\V20150109\AddDomainRecordRequest;

class DnsCurl extends BaseCurl
{
    /**
     * 返回惟一实例
     *
     * @return DnsCurl
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
        return new AddDomainRecordRequest();
    }

    /**
     * 增加域名解析
     * 
     * @param string $_strNetIp 网络IP
     * @param string $_strDomainRR 域名前缀
     * @param string $_strDomain 主域名 
     * 
     * @return RecordId 记录ID
     *
     * @author xiaoyi
     * @date 2016年10月21日
     */
    public function addDomainRecord($_strNetIp, $_strDomainRR, $_strDomain="")
    {
        // 创建数据
        $aryParam = [
                "DomainName" => $_strDomain,
                'RR' => $_strDomainRR,
                'Type' => "A",
                'Value' => $_strNetIp,
                'TTL' => 600,
        ];
        
        //  返回数据
        $aryResult = $this->getResult("AddDomainRecord", $aryParam);
        return $aryResult['RecordId'];
    }
}