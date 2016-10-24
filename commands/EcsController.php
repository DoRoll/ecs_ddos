<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use DefaultProfile;
use DefaultAcsClient;
// use Ecs\Request\V20140526\DescribeRegionsRequest;
use Rds\Request\V20140815\DescribeRegionsRequest;
use app\server\EcsServer;

class EcsController extends Controller
{
    public function actionIndex()
    {
        
    }

    /**
     * 获取ecs有多少实例
     *
     * @author xiaoyi
     * @date 2016年10月15日
     */
    public function actionList()
    {
        $objClientProfile = DefaultProfile::getProfile("cn-shenzhen", "", "");
        $client = new DefaultAcsClient($objClientProfile);
        $objRequest = new DescribeRegionsRequest();
        $objRequest->setMethod("GET");
        $objRequest->setActionName("DescribeInstances");
        $objRequest->setRegionId("cn-shenzhen");
        $objRequest->setParams(['PageSize'=>10, "InstanceChargeType"=>"PostPaid"]);
        $objResponse = $client->getAcsResponse($objRequest);
        print_r($objResponse);
        exit();
    }
    
    public function actionCreate()
    {
           EcsServer::server()->create(1);
//         $objClientProfile = DefaultProfile::getProfile("cn-shenzhen-a", "", "");
//         $client = new DefaultAcsClient($objClientProfile);
//         $objRequest = new DescribeRegionsRequest();
//         $objRequest->setMethod("GET");
//         $objRequest->setActionName("CreateInstance");
//         $objRequest->setRegionId("cn-shenzhen");
        
//         $aryParams=[
//                 'ZoneId' => 'cn-shenzhen-a',
//                 'ImageId' => 'm-wz92wgxq1l7c9qv0sntu',
//                 'InstanceType' => 'ecs.t1.small',
//                 'SecurityGroupId' => 'sg-94ktpl33s',
//                 'InstanceName' => '测试接口创建临时实例',
//                 'Description' => '主要为了测试接口创建临时实例信息',
//                 'InternetChargeType' => 'PayByTraffic',// 按流量计费
//                 'InternetMaxBandwidthOut' => 5,
//                 'HostName' => 'root',
//                 'Password' => 'JSKRI(sflOksk80284F',
//                 'IoOptimized' => 'none',
//                 'SystemDisk.Category' => 'cloud',
//                 'SystemDisk.Size' => '40',
//                 'SystemDisk.DiskName' => '测试临时实例磁盘',
//                 'SystemDisk.Description' => '测试接口创建的临时实例',
//                 'DataDisk.n.DeleteWithInstance' => 'true',
//                 'InstanceChargeType' => 'PostPaid',
//                 'ClientToken' => md5(time()),
//         ];
//         $objRequest->setParams($aryParams);
        
//         $objResponse = $client->getAcsResponse($objRequest);
//         print_r($objResponse);
//         exit();
    }
    
    public function actionDelete()
    {
        $objClientProfile = DefaultProfile::getProfile("cn-shenzhen", "", "");
        $client = new DefaultAcsClient($objClientProfile);
        $objRequest = new DescribeRegionsRequest();
        $objRequest->setMethod("GET");
        $objRequest->setActionName("DeleteInstance");
        $objRequest->setRegionId("cn-shenzhen");
        $objRequest->setParam("InstanceId", "i-wz95nv2vjn03tju4mnal");
        
        $objResponse = $client->getAcsResponse($objRequest);
        print_r($objResponse);
        exit();
    }
    
    public function actionDeleteRds()
    {
        $objClientProfile = DefaultProfile::getProfile("cn-shenzhen", "", "");
        $client = new DefaultAcsClient($objClientProfile);
        $objRequest = new DescribeRegionsRequest();
        $objRequest->setMethod("GET");
        $objRequest->setActionName("DeleteDBInstance");
        $objRequest->setRegionId("cn-shenzhen");
        $objRequest->setParam("DBInstanceId", "rm-wz911zi63905nga4m");
    
        $objResponse = $client->getAcsResponse($objRequest);
        print_r($objResponse);
        exit();
    }
}
