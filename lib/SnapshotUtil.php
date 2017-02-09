<?php
namespace app\lib;

/**
 * Ecs基类
 * 
 * @return EcsUtil
 */
class SnapshotUtil
{
    /** 快照状态 - 创建中 1 */
    const SNAP_STATUS_PROGRESSING = 1;
    
    /** 快照状态 - 创建完成 */
    const SNAP_STATUS_ACCOMPLISHED = 2;
    
    /** 快照状态 - 创建失败 */
    const SNAP_STATUS_FAILED = -1;
    
}
