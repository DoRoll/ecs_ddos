<?php
namespace app\server\curl;

use app\server\curl\BaseCurl;
use Ecs\Request\V20140526\CreateSnapshotRequest;

/**
 * 创建快照
 *
 * @author root
 */
class SnapshotCurl extends BaseCurl
{
    /**
     * 返回惟一实例
     *
     * @return SnapshotCurl
     */
    public static function server( $className = __CLASS__ )
    {
        return parent::server($className);
    }
    
    /**
     * 返回request对象
     * 
     * {@inheritDoc}
     * @see \app\server\curl\BaseCurl::requestInstance()
     * 
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function requestInstance()
    {
        return new CreateSnapshotRequest();
    }
    
    /**
     * 为指定磁盘创建快照
     * 
     * @param string $_strBatch 批次
     * @param string $_strDiskId 磁盘ID
     * 
     * @return string  快照ID
     *
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function create($_strBatch="", $_strDiskId="")
    {
        $aryParam = [
                'DiskId' => $_strDiskId,
                'SnapshotName' => "M_{$_strBatch}_D_{$_strDiskId}",
                'Description' => "磁盘{$_strDiskId}在{$_strBatch}中快照",
        ];
        $aryResult = $this->getResult("CreateSnapshot", $aryParam);
        return $aryResult['SnapshotId'];
    }
    
    /**
     * 删除一个快照
     * 
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function delete()
    {
        $this->getResult("DeleteSnapshot", ['SnapshotId'=>"s-wz919ccp2hp43i22dnwc"]);
        return true;
    }
    
    /**
     * 获取snap信息
     * 
     * @param string $_strDiskId 磁盘ID
     * @param string $_strSnapId 快照ID
     *
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function getSnapInfo($_strDiskId="", $_strSnapId="")
    {
        $aryParam = [
                'RegionId' => $_strDiskId,
                'SnapshotIds' => '["'.$_strSnapId.'"]',
        ];
        
        $aryResult = $this->getResult("DescribeSnapshots", $aryParam);
        return $aryResult['Snapshots']['Snapshot'][0];
    }
    
}