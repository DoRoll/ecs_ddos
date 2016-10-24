<?php

namespace app\server\curl;

use DefaultProfile;
use DefaultAcsClient;
use Ecs\Request\V20140526\DescribeRegionsRequest;
use Yii;
use app\exception\ErrorException;

/**
 * server 基类
 * 
 * @author xiaoyi
 */
class BaseCurl
{
    private static $_classServer = array();
    protected $_objClient;
    protected $_strZone;
    
    /**
     * 设置地域
     * 
     * @param string $_strZone 所属地域
     *
     * @author xiaoyi
     * @date 2016年10月19日
     */
    public function setZone($_strZone="")
    {
        $this->_strZone = $_strZone;
    }
    
    /**
     * 获取zone
     * 
     * @return string
     *
     * @author xiaoyi
     * @date 2016年10月19日
     */
    public function getZone()
    {
        return $this->_strZone;
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
        return null;
    }
    
    /**
     * 创建Server
     *
     * @param object $className
     * @return Server
     *
     * @author xiaoyi
     * @date 2015-07-04
     */
    public static function server($className = __CLASS__)
    {
        if(!isset(self::$_classServer[$className]))
        {
            self::$_classServer[$className] = new $className();
        }
        return self::$_classServer[$className];
    }
    
    /**
     * 获取proFile对象 
     *
     * @author xiaoyi
     * @date 2016年10月19日
     */
    public function getObjClient()
    {
        $strAccessId = Yii::$app->params['ali']['OSS_ACCESS_ID'];
        $strKey = Yii::$app->params['ali']['OSS_ACCESS_KEY'];
        $objClientProfile = DefaultProfile::getProfile(ECS_ZONE, $strAccessId, $strKey);
        return new DefaultAcsClient($objClientProfile);
    }
    
    /**
     * 实现getObjRequest方法
     * 
     * @param string $_strActioName 控制器名称
     * 
     * {@inheritDoc}
     * @see \app\server\curl\CurlInterface::getObjRequest()
     * 
     * @author xiaoyi
     * @date 2016年10月21日
     */
    public function getObjRequest($_strActioName="")
    {
        $objRequest = $this->requestInstance();
        $objRequest->setMethod("GET");
        $objRequest->setActionName($_strActioName);
        $objRequest->setRegionId(ECS_ZONE);
        return $objRequest;
    }
    
    /**
     * 返回数据
     * 
     * @param string $_strActioName 需要操作的控制器名称
     * @param array $_aryParam 参数
     *
     * @author xiaoyi
     * @date 2016年10月21日
     */
    public function getResult($_strActioName="", $_aryParam)
    {
        $objRequest = $this->getObjRequest($_strActioName);
        $objRequest->setParams($_aryParam);
        try {
            $objResponse = $this->getObjClient()->getAcsResponse($objRequest);
            $strResult = json_encode($objResponse);
            return json_decode($strResult, true);
        } catch(\Exception $e){
            throw new ErrorException($e->getMessage());
        }
    }
}