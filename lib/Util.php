<?php
namespace app\lib\util;

/**
 * 基类
 * 
 * @author xiaoyi
 */
class Util
{
    /**
     * 计算试用时间 
     *
     * @author xiaoyi
     * @date 2015年9月1日
     */
    public static function calculateTryTime($_intTime=0)
    {
        if($_intTime<=0)
            return "0秒";
        
    }
    
    /**
     * 文件大小转换
     * 
     * @param number $_intSize 文件大小(最小单位 kb)
     *
     * @author xiaoyi
     * @date 2015年9月1日
     */
    public static function formatByte($_intSize=0)
    {
        $aryUnits = ['B', 'K', 'M', 'G', 'T'];
        for ($i = 0; $_intSize >= 1024 && $i < 4; $i++)
            $_intSize /= 1024;
        return round($_intSize, 2).$aryUnits[$i];
    }
    
    /**
     * 计算当天时间戳
     *
     * @return strtotime(date('Y-m-d', time()))
     *
     * @author xiaoyi
     * @date 2015年9月6日
     */
    public static function mathDayTime()
    {
        return strtotime(date('Y-m-d', time()));
    }
    
    /**
     * 将时间转换成(年-月-日形式)
     * 
     * @param string $_strTime 时间
     * @param number $_intStringToInt 转换格式(1=>字符串时间转linux时间戳,2=>linux时间戳转字符串时间)
     *
     * @author xiaoyi
     * @date 2015年10月26日
     */
    public static function formatDayTime($_strTime="", $_intStringToInt=1)
    {
        return $_intStringToInt == 1 ? (strtotime(date('Y-m-d', strtotime($_strTime)))) : date('Y-m-d', $_strTime);
    }
    
    /**
     * 字符串截取
     * 
     *
     * @author xiaoyi
     * @date 2015年9月8日
     */
    public static function substr($_strContent="", $_intLength=0, $etc = '...')
    {
        $result = '';
        $_strContent = html_entity_decode(trim(strip_tags($_strContent)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($_strContent);
        for($i = 0; (($i < $strlen) && ($_intLength > 0)); $i++)
        {
            if($number = strpos(str_pad(decbin(ord(substr($_strContent, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
            {
                if($_intLength < 1.0)
				    break;
				$result .= substr($_strContent, $i, $number);
				$_intLength -= 1.0;
				$i += $number - 1;
            }
            else
          {
                $result .= substr($_strContent, $i, 1);
                $_intLength -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen)
            $result .= $etc;
        return $result;
    }
    
    /**
     * 生成无顺序缓存key
     * 
     * @author xiaoyi
     * @date 2015年10月6日
     */
    public static function generateCacheKey()
    {
        // 获得一个32位串，再将串数据随机散列10次
        $strKey = md5(''.time().rand(1000,2000));
        $aryKeys = str_split($strKey);
        $charValue = 0;
        for($i=0; $i<10; $i++)
        {
            $intBegin = rand(0,31);
            $intEnd = rand(0,31);
            if($intBegin == $intEnd)
            {
                $i--;
                continue;
            }
            
            // 进行换水操作
            $charValue = $aryKeys[$intBegin];
            $aryKeys[$intBegin] = $aryKeys[$intEnd];
            $aryKeys[$intEnd] = $charValue;
        }
        return implode("", $aryKeys);
    }
    
    /**
     * 获取分页页面大小
     *
     * @author xiaoyi
     * @date 2015年11月13日
     */
    public static function pageNumList()
    {
        return [10,20,30,50,70,80,100];
    }
    
    /**
     * 根据ip地址获取省份
     *
     * @param string $_strIp ip地址
     *
     * @return string
     *
     * @author xiaoyi
     * @date 2015年11月3日
     */
    public static function getProvinceByIp($_strIp="")
    {
        $aryResult = CurlUtil::IPInfo($_strIp);
        return empty($aryResult['province']) ? "未知" :
                ($aryResult['province']=="None" ? 
                    (empty($aryResult['country']) ? "未知" : $aryResult['country']) 
                : $aryResult['province']);
    }
    
    /**
     * 计算某值归属某张表
     *
     * @author xiaoyi
     * @date 2015年12月17日
     */
    public static function mathTable($_strValue="", $_intCount=100)
    {
        // 获取md5值
        $strMd5 = md5($_strValue);
        $aryValue = str_split($strMd5);
        $strCount = "";
        
        // 将md5值打散,提取数字
        foreach($aryValue as $strValue)
        {
            if(intval($strValue)>0)
                $strCount .= $strValue;
            if(strlen($strCount) > 7)
                break;
        }
        if(empty($strCount))
            return 1;
        
        // 获取余数
        $intNum = intval($strCount);
        return $intNum%$_intCount;
    }
    
    /**
     * 生成指定文件夹
     *
     * @param string $_strPath
     *
     * @author xiaoyi
     * @date 2016年3月30日
     */
    public static function mkdir($_strFilePath="")
    {
        $strPath = "";
        if(!file_exists($_strFilePath))
        {
            // 否则开始生成文件夹
            $aryDir = explode('/', $_strFilePath);
            foreach ($aryDir as $strDir)
            {
                $strPath .= $strDir.'/';
                if (!file_exists($strPath))
                {
                    $oldumask=umask(0);
                    mkdir($strPath, 0777);
                    umask($oldumask);
                }
            }
        }
        return true;
    }
}
