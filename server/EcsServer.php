<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\server;

use app\models\EcsConfig;
use app\server\curl\EcsCurl;
use app\models\EcsList;
use app\server\curl\RdsCurl;
use app\server\curl\DnsCurl;

class EcsServer extends BaseServer
{
    /**
     * 返回惟一实例
     *
     * @return EcsServer
     */
    public static function server( $className = __CLASS__ )
    {
        return parent::server($className);
    }

    /**
     * 创建ecs
     * 
     * @param number $_intCount 所需台数
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    public function create($_intCount=0)
    {
        // 获取所要操作的地域
        $aryEcsConfig = EcsConfig::model()->getInfoById(3, false);
        define("ECS_ZONE", $aryEcsConfig['zone']);
        
        // 创建一个订单 
        $strMd5= md5(rand(2000,5000).time()."ecs".rand(4000,8000).rand(3000,9000));
        $strMd5 = substr($strMd5, 1, 6);
        
        $aryTemp = [];
        for($i=1; $i<=$_intCount; $i++)
        {
            try {
                // 创建ecs并写入记录
//                 $strEcsId = EcsCurl::server()->create($strMd5, $aryEcsConfig, $i);
                $strEcsId = "i-wz95nv2vjn03tju4mnal";
                $intId = (new EcsList())->addNew($strEcsId, $strMd5, 3, $strMd5);
                echo "创建ecs成功:id:{$strEcsId}\r\n";
                
                // 获取ecs信息
                $aryEcsInfo = EcsCurl::server()->getEcsInfo($strEcsId, $aryEcsConfig['zone']);
                $strLocalIp = $aryEcsInfo['InnerIpAddress']['IpAddress'][0];
                EcsList::model()->updateLocalIp($intId, $strLocalIp);
                echo "本地IP:$strLocalIp\r\n";
                
                // 给ecs分配IP
//                 $strNetIp = EcsCurl::server()->allocateIp($strEcsId);
                $strNetIp = "120.24.220.175";
                EcsList::model()->updateNetIp($intId, $strNetIp);
                echo "网络Ip:{$strNetIp}\r\n";
                
                // 增加RDS白名单
                $this->addRdsIpList($aryEcsConfig['rds'], $strLocalIp);
                
                // 启动ECS
                $aryTemp[] = ['ecs_id'=>$strEcsId, 'id'=>$intId, 'net_ip'=>$strNetIp];
            } catch (Exception $e) {
                echo $e->getMssage();
                exit();
            }
        }
        $this->start($aryTemp);
    }
    
    /**
     * 启动ecs
     * 
     * @param array $_aryData
     *
     * @author xiaoyi
     * @date 2016年10月18日
     */
    private function start($_aryData=[])
    {
        //先批量启动ecs
        $aryTemp = [];
        foreach($_aryData as $aryInfo)
        {
            try {
                EcsCurl::server()->start($aryInfo['ecs_id']);
                echo "已申请启动服务器:{$aryInfo['ecs_id']}\r\n";
                $aryTemp[] = $aryInfo;
            } catch (\Exception $e) {
                continue;
            }
        }
        
        // 轮询哪几台服务器启动完成
        for($i=1; $i<=200; $i++)
        {
            $aryUnRunEcsTemp =[];
            foreach($aryTemp as $aryInfo)
            {
                try {
                    // 如果服务器启动未完成,则跳过
                    $aryEcsInfo = EcsCurl::server()->getEcsInfo($aryInfo['ecs_id']);
                    if($aryEcsInfo['Status'] != "Running")
                    {
                        echo "第{$i}次轮询.服务器:{$aryInfo['ecs_id']}未启动成功\r\n";
                        $aryUnRunEcsTemp[] = $aryInfo;
                        continue;
                    }
                    echo "第{$i}此轮询,服务器:{$aryInfo['ecs_id']}已经启动成功\r\n";
                    
                    // 如果服务器启动完成,则解析DNS
                    DnsCurl::server()->addDomainRecord($aryInfo['net_ip'], "info", "notephp.com");
                    echo "服务器{$aryInfo['ecs_id']}已完成域名解析\r\n";
                    unset($aryInfo);
                    sleep(1);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            }
            
            $aryTemp = $aryUnRunEcsTemp;
            if(empty($aryTemp))
                break;
            sleep(3);
        }
        echo "完成\r\n";
        return true;
    }
    
    /**
     * 添加rds白名单
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    private function addRdsIpList($_strRds, $_strLocalIp="", $_strZone="")
    {
        if(empty($_strRds))
            return true;
        
        $aryRdsList = explode(",", $_strRds);
        foreach($aryRdsList as $strRdsId)
        {
            $strIp = RdsCurl::server()->getIpList($_strRds);
            $strIp = empty($strIp) ? $_strLocalIp : $strIp.",".$_strLocalIp;
            RdsCurl::server()->setIp($strIp, $strRdsId);
        }
        return true;
    }
}
