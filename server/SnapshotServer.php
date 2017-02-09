<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\server;

use app\server\curl\SnapshotCurl;
use app\models\Disk;
use app\lib\Util;
use app\models\Snapshot;
use app\lib\SnapshotUtil;
class SnapshotServer extends BaseServer
{
    /**
     * 返回惟一实例
     *
     * @return SnapshotServer
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
        $strBatch = Util::batch(6);
        
        // 发送创建快照命令
        $arySnapList = [];
        $aryDiskList = Disk::model()->getDiskList();
        foreach($aryDiskList as $aryDiskInfo)
        {
            try
            {
                $objSnapModel = new Snapshot();
                $strSnapshotId = SnapshotCurl::server()->create($strBatch, $aryDiskInfo['disk_id']);
                echo $strSnapshotId, "\r\n";
                $aryParam = [
                        'batch' => $strBatch,
                        'snapshot_id' => $strSnapshotId,
                        'disk_id' => $aryDiskInfo['disk_id'],
                        'status' => SnapshotUtil::SNAP_STATUS_PROGRESSING,
                ];
                $intId = $objSnapModel->addNew($aryParam);
                $arySnapList[] = [
                        'snapshot_id' => $strSnapshotId,
                        'disk_id' => $aryDiskInfo['disk_id'],
                        'id' => $intId,
                ];
            } catch (\Exception $e)
            {
                continue;
            }
        }
        
        for($i=1; $i<=100; $i++)
        {
            $aryTemp = [];
            foreach($arySnapList as $aryInfo)
            {
                $arySnapInfo = SnapshotCurl::server()->getSnapInfo($aryInfo['disk_id'], $aryInfo['snapshot_id']);
                
                $intStatus = SnapshotUtil::SNAP_STATUS_PROGRESSING;
                if($arySnapInfo['Status'] == "progressing")
                {
                    echo "第{$i}次轮询中发现快照{$aryInfo['snapshot_id']}未创建完成\r\n";
                    $aryTemp[] = $aryInfo;
                    continue;
                }
                else if($arySnapInfo['Status'] == "failed")
                {
                    echo "第{$i}次轮询中发现快照{$aryInfo['snapshot_id']}创建失败\r\n";
                    $intStatus = SnapshotUtil::SNAP_STATUS_FAILED;
                }
                else if($arySnapInfo['Status'] == "accomplished")
                {
                    echo "第{$i}次轮询中发现快照{$aryInfo['snapshot_id']}创建完成\r\n";
                    $intStatus = SnapshotUtil::SNAP_STATUS_ACCOMPLISHED;
                }
                else
                {
                    $intStatus = SnapshotUtil::SNAP_STATUS_FAILED;
                }
                Snapshot::model()->compile($aryInfo['id'], $intStatus);
            }
            if(empty($aryTemp))
                break;
            
            $arySnapList = $aryTemp;
            sleep(3);
        }
        
        echo "程序执行完成";
    }
}
