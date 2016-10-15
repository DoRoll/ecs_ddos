<?php
namespace app\models;
use Yii;
use app\lib\util\Util;
use app\exception\ErrorException;
use yii\data\Pagination;

class BaseModel extends \yii\db\ActiveRecord
{
    private static $_classModel = array();
    
    public $_strDefaultPrimaryKey = "id";
    
    public $_intPageSize = 10;
    
    private $_objUtil = null;
    
    /**
     * 设置页面显示条数
     * 
     * @param int $_intPageSize 页面显示条数
     *
     * @author xiaoyi
     * @date 2015年7月9日
     */
    public function setPageSize($_intPageSize=10)
    {
        $this->_intPageSize = $_intPageSize;
    }
    
    /**
     * 获取Page分页对象
     * 
     * @param int $_intTotal 总数
     *
     * @author xiaoyi
     * @date 2015年7月9日
     */
    public function getPageObject($_intTotal=1)
    {
        return new Pagination($_intTotal , $this->getPageSize());
    }
    
    /**
     * 获取页面显示条数
     * 
     * @return Ambigous <number, int>
     *
     * @author xiaoyi
     * @date 2015年7月9日
     */
    public function getPageSize()
    {
        if(!empty(Yii::$app->request->get("page_num", "")))
        {
            $intPage = intval(Yii::$app->request->get("page_num", 10));
            $this->_intPageSize = in_array($intPage, Util::pageNumList()) ? $intPage : 10;
        }
        return $this->_intPageSize;
    }
    
    /**
     * 设置默认主键
     *
     * @param string $_strPrimaryKey 默认主键
     *
     * @author xiaoyi
     * @date 2015年7月7日
     */
    public function setDefaultPrimaryKey($_strPrimaryKey="")
    {
        $this->_strDefaultPrimaryKey = $_strPrimaryKey;
    }
    
    /**
     * 获取默认主键
     * 
     * @return string
     *
     * @author xiaoyi
     * @date 2015年7月7日
     */
    public function getDefaultPrimaryKey()
    {
        return $this->_strDefaultPrimaryKey;
    }
    
    /**
     * 创建model
     * 
     * @param object $className
     * @return Model
     * 
     * @author xiaoyi
     * @date 2015-07-04
     */
    public static function model($className = __CLASS__)
    {
        if(!isset(self::$_classModel[$className]))
            self::$_classModel[$className] = new $className();
        return self::$_classModel[$className];
    }
    
    /**
     * 转换model，将数据赋值到指定Key
     * 
     * @param array $_aryData 需要设置的数据array(key=>value)
     * 
     * @return boolean
     * 
     * @author xiaoyi
     * @date 2015-07-04
     */
    public function formatModel($_aryData=array())
    {
        $boolFlag = false;
        if(!empty($_aryData))
        {
            foreach($_aryData as $strKey=>$strValue)
            {
                $this->$strKey=$strValue;
            }
            $boolFlag = true;
        }
        return $boolFlag;
    }
    
    /**
     * 创建新数据
     *
     * @param array $_aryData 需要新增的数据
     * @param string $_strMsg 异常消息
     * 
     * @throws ErrorException
     * 
     * @return $int 
     *
     * @author xiaoyi
     * @date 2015年7月6日
     */
    public function createNew($_aryData=array(), $_strMsg="")
    {
        $strScenario = $this->getScenario()=="default" ? 'create' : $this->getScenario();
        $this->setScenario($strScenario);
        $this->formatModel($_aryData);
        
        // 创建数据
        $this->setIsNewRecord(true);
        $boolResult = $this->save(true);
        
        if(!$boolResult)
            throw new ErrorException((empty($_strMsg) ? "新增失败" : $_strMsg));
        else
           return $this->attributes['id'];
    }
    
    /**
     * 根据id修改数据
     * 
     * @param number $intId id主键
     * @param array $_aryData 需要修改的数据
     * @param string $_strMsg 异常消息
     * 
     * @throws ErrorException
     * 
     * @return boolean
     *
     * @author xiaoyi
     * @date 2015年7月7日
     */
    public function updateById($_intId=0, $_aryData=array(), $_strMsg="")
    {
        $_aryData[$this->getDefaultPrimaryKey()] = $_intId;
        $strScenario = $this->getScenario()=="default" ? 'update' : $this->getScenario();
        $this->setScenario($strScenario);
        $this->setIsNewRecord(false);
        $this->formatModel($_aryData);
        if(!($this->save(true)))
            throw new ErrorException((empty($_strMsg) ? "修改失败" : $_strMsg));
        return true;
    }

    /**
     * 重写查询条件
     * 
     * (non-PHPdoc)
     * @see \yii\db\BaseActiveRecord::getOldPrimaryKey($asArray)
     * 
     * @author xiaoyi
     * @date 2015-07-07
     */
    public function getOldPrimaryKey($asArray = false)
    {
        $keys = $this->primaryKey();
        $values = [];
        foreach ($keys as $name) {
            $values[$name] = isset($this->$name) ? $this->$name : null;
        }
        return $values;
    }
    
    /**
     * 根据sql查询
     * 
     * @param $_strSql sql脚本文件
     * 
     * @return object
     *
     * @author xiaoyi
     * @date 2015年7月8日
     */
    public function queryBySql($_strSql="")
    {
        return Yii::$app->db->createCommand($_strSql)->queryAll();
    }
    
    /**
     * 根据sql查询
     *
     * @param $_strSql sql脚本文件
     *
     * @return object
     *
     * @author limeng
     * @date 2015年12月21日
     */
    public function queryByOne($_strSql="")
    {
        //queryOne
        return Yii::$app->db->createCommand($_strSql)->queryOne();
    }
    
    /**
     * 修个sql语句
     *
     * @param $_strSql sql脚本文件
     *
     * @return object
     *
     * @author limeng
     * @date 2015年12月21日
     */
    public function query($_strSql="")
    {
        return Yii::$app->db->createCommand($_strSql)->execute();
    }
    
    /**
     * 根据sql查询总数
     * 
     * @param string $_strSql
     *
     * @author xiaoyi
     * @date 2015年7月21日
     */
    public function countBySql($_strSql="")
    {
        $aryResult = $this->queryBySql($_strSql);
        return $aryResult[0]['count'];
    }

    /**
     * 数据自增长
     *
     * @author xiaoyi
     * @date 2015年7月16日
     */
    public function autoIncreaseById($_intId=0 , $_aryData=array())
    {
        $strSql = "update ".$this->tableName()." set ";
        $aryParams = [];
        foreach($_aryData as $strKey => $strValue)
        {
            $aryParams[] = "`$strKey` = `$strKey`+$strValue";
        }
        $strSql .= implode(" , ", $aryParams);
        $strSql .= " where id=$_intId";
        return Yii::$app->db->createCommand($strSql)->execute();
    }
    
    /**
     * 根据id获取详细信息
     *
     * @param number $_intId id值
     * @param string $_boolIsObject 是否需要对象
     *
     * @return array|object
     *
     * @author xiaoyi
     * @date 2015年10月7日
     */
    public function getInfoById($_intId=0, $_boolIsObject=true)
    {
        if($_intId<=0)
            return $_boolIsObject ? null : [];
        if($_boolIsObject)
            return $this->findByCondition(['id'=>$_intId])->one();
        else
            return $this->findByCondition(['id'=>$_intId])->asArray()->one();
    }
    
    /**
     * 转换数据
     * 
     * @author xiaoyi
     * @date 2016年4月14日
     */
    public function formatData($_aryData=[], $_strKey="id")
    {
        if(empty($_aryData))
            return [];
        
        $aryTemp = [];
        foreach($_aryData as $aryInfo)
        {
            $aryTemp[$aryInfo[$_strKey]] = $aryInfo;
        }
        return $aryTemp;
    }
    
    /**
     * 创建sort排序
     *
     * @param array $_aryMap
     * @param array $_aryDefault
     *
     * @author xiaoyi
     * @date 2015年11月12日
     */
    public function createSort($_aryMap=[], $_aryDefault=[])
    {
        $aryTemp = [];
        $aryParams = Yii::$app->request->get();
        foreach($_aryMap as $strKey=>$strValue)
        {
            if(!empty($aryParams[$strKey]))
                $aryTemp[$strValue] = $aryParams[$strKey] === "-1" ? SORT_ASC : SORT_DESC;
        }
        
        return empty($aryTemp) ? $_aryDefault : $aryTemp;
    }
    
    /**
     * 删除数据
     * 
     * @param int $_intId id
     * @package string $_strMsg 消息
     *
     * @author xiaoyi
     * @date 2016年5月26日
     */
    public function delById($_intId=0, $_strMsg="")
    {
        if(($this->deleteAll(['id'=>$_intId]))<=0)
        {
            $strMsg = empty($_strMsg) ? "删除失败" : $_strMsg;
            throw new ErrorException($strMsg);
        }
        return true;
    }
}
