<?php
namespace app\server\curl;

use app\server\curl\BaseCurl;
use app\exception\ErrorException;
use Ecs\Request\V20140526\DescribeRegionsRequest;

class EcsCurl extends BaseCurl
{
    /**
     * 返回惟一实例
     *
     * @return EcsCurl
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
        return new DescribeRegionsRequest();
    }
    
    /**
     * 创建ecs
     *
     * @author xiaoyi
     * @date 2016年10月15日
     */
    public function create($_strMd5="", $_aryConfig=[], $_intCount=0)
    {
        // 设置参数
        $aryParams=[
                'ZoneId' => $_aryConfig['zone_id'],
                'ImageId' => $_aryConfig['image_id'],
                'InstanceType' => $_aryConfig['instance_type'],
                'SecurityGroupId' => $_aryConfig['security_group_id'],
                'InstanceName' => "M{$_strMd5}_{$_intCount}_".$_aryConfig['instance_name'],
                'Description' => "M{$_strMd5}_{$_intCount}_".$_aryConfig['description'],
                'InternetChargeType' => $_aryConfig['internet_charge_type'],// 按流量计费
                'InternetMaxBandwidthOut' => $_aryConfig['internet_max_bandwidth_out'],
                'HostName' => $_aryConfig['host_name'],
                'Password' => $_aryConfig['password'],
                'IoOptimized' => $_aryConfig['io_optimized'],
                'SystemDisk.Category' => $_aryConfig['system_disk_category'],
                'SystemDisk.Size' => $_aryConfig['system_disk_size'],
                'SystemDisk.DiskName' => "M{$_strMd5}_{$_intCount}_".$_aryConfig['system_disk_diskname'],
                'SystemDisk.Description' => "M{$_strMd5}_{$_intCount}_".$_aryConfig['system_disk_description'],
                'InstanceChargeType' => $_aryConfig['instance_charge_type'],
                'ClientToken' => md5(time().rand(1000,2000).rand(4000,9000).$_strMd5.$_intCount),
        ];
        
        // 返回数据
        $aryResult = $this->getResult("CreateInstance", $aryParams);
        return $aryResult['InstanceId'];
    }
    
    /**
     * 给ecs分配ip
     * 
     * @param string $_strEcsId
     *
     * @author xiaoyi
     * @date 2016年10月15日
     */
    public function allocateIp($_strEcsId="")
    {
        $aryParam = ['InstanceId' => $_strEcsId];
        $aryResult = $this->getResult("AllocatePublicIpAddress", $aryParam);
        return $aryResult['IpAddress'];
    }
    
    /**
     * 根据ecs id 获取信息
     * 
     * @param string $_strEcsId ecsId
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    public function getEcsInfo($_strEcsId="")
    {
        $aryParam = [
                'InstanceIds' => '["'.$_strEcsId.'"]',
        ];
        $aryResult = $this->getResult("DescribeInstances", $aryParam);
        return $aryResult['Instances']['Instance'][0];
    }
    
    /**
     * 启动ECS
     * 
     * @param string $_strEcsId ecsId
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    public function start($_strEcsId="")
    {
        $this->getResult("StartInstance", ["InstanceId"=>$_strEcsId]);
        return true;
    }
}