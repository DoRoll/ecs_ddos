<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\server\curl\SnapshotCurl;
use app\server\SnapshotServer;

/**
 * 磁盘快照管理
 * 
 * @author root
 */
class SnapController extends Controller
{
    /**
     * 创建磁盘快照
     *
     * @author xiaoyi
     * @date 2017年2月9日
     */
    public function actionCreate()
    {
        SnapshotServer::server()->create();
    }
    
    /**
     * 删除某个磁盘快照
     *
     * @author xiaoyi
     * @date 2017年2月9日
     */
    public function actionDelete()
    {
        SnapshotCurl::server()->delete();
    }
}
