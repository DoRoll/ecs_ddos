<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\server\IsoServer;
use app\server\ImageServer;

class IsoController extends Controller
{
    /**
     * 删除一个镜像
     * 
     * @author xiaoyi
     * @date 2015年9月1日
     */
    public function actionDelete()
    {
        ImageServer::server()->delete();
    }
}
