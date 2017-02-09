<?php
namespace app\server\curl;

use app\server\curl\BaseCurl;
use Ecs\Request\V20140526\CreateImageRequest;

/**
 * 创建快照
 *
 * @author root
 */
class ImageCurl extends BaseCurl
{
    /**
     * 返回惟一实例
     *
     * @return ImageCurl
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
        return new CreateImageRequest();
    }
    
    /**
     * 删除一个快照
     * 
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function delete()
    {
        $aryParam = [
                'ImageId' =>'m-wz9gsnrlfzjzk3ariwyk',
                'RegionId' => 's-wz9gsnrlfzjzk3apjbbp',
        ];
        $aryResult = $this->getResult("DeleteImage", $aryParam);
        return $aryResult;
    }
    
}