<?php
namespace app\lib;

/**
 * Ecs基类
 * 
 * @return EcsUtil
 */
class EcsUtil
{
    /** ecs状态 - 关机 1 */
    const ECS_STATUS_SHUTDOWN = 1;
    
    /** ecs状态 - 已申请IP 2 */
    const ECS_STATUS_IP = 2;
    
    /** ecs状态 - 正常 3 */
    const ECS_STATUS_NORMAL = 3;
    
    /** ecs状态 - 重启 4 */
    const ECS_STATUS_REBOOT = 4;
    
    /** ecs状态 - 删除 -1 */
    const ECS_STATUS_DELETE = -1;
    
    /** ecs是否绑定DNS - 绑定 */
    const ECS_DNS_STATUS_BIND = 1;
    
    /** ecs是否绑定DNS - 未绑定 */
    const ECS_DNS_STATUS_UNBIND = 2;
    
    /** ecs 内网域名是否已经加入mysql白名单 - 已添加 1 */
    const ECS_MYSQL_STATUS_ADD = 1;
    
    /** ecs 内网域名是否已经加入mysql白名单 - 未添加 2 */
    const ECS_MYSQL_STATUS_UNADD = 2;
}
