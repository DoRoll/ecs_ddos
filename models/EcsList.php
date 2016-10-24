<?php

namespace app\models;

use Yii;
use app\lib\EcsUtil;

/**
 * This is the model class for table "ecs_list".
 *
 * @property integer $id
 * @property string $md5
 * @property string $ecs_id
 * @property integer $config_id
 * @property string $local_ip
 * @property string $net_ip
 * @property integer $status
 * @property integer $dns_bind
 * @property integer $sql_in_white_list
 * @property integer $create_at
 * @property integer $update_at
 * @property string $comment
 */
class EcsList extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TABLE_PREFIX.'ecs_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at'], 'default', 'value'=>time()],
            [['config_id', 'status', 'dns_bind', 'sql_in_white_list', 
                    'create_at', 'update_at'], 'integer'],
            [['md5', 'ecs_id', 'local_ip', 'net_ip'], 'string', 'max' => 32],
            [['comment'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * 返回惟一实例
     *
     * @return EcsList
     */
    public static function model( $className = __CLASS__ )
    {
        return parent::model($className);
    }
    
    /**
     * 继承验证环境
     *
     * @see \yii\base\Model::scenarios()
     */
    public function scenarios()
    {
        $parent = parent::scenarios();
        $parent['create'] = ['md5', 'ecs_id', 'config_id', 'status', 'dns_bind', 'sql_in_white_list',
                                'create_at', 'update_at', 'comment'];
        $parent['local_ip'] = ['local_ip', 'update_at'];
        $parent['net_ip'] = ['net_ip', 'update_at'];
        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'md5' => 'Md5',
            'ecs_id' => 'Ecs ID',
            'config_id' => 'Config ID',
            'local_ip' => 'Local Ip',
            'net_ip' => 'Net Ip',
            'status' => 'Status',
            'dns_bind' => 'Dns Bind',
            'sql_in_white_list' => 'Sql In White List',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'comment' => 'Comment',
        ];
    }
    
    /**
     * 创建一个新值
     * 
     * @param ecsId $_strEcsId
     *
     * @author xiaoyi
     * @date 2016年10月15日
     */
    public function addNew($_strEcsId="", $_strMd5="", $_intConfigId=0, $_strComment="")
    {
        $aryTemp = [
                'md5' => $_strMd5,
                'ecs_id' => $_strEcsId,
                'config_id' => $_intConfigId,
                'status' => EcsUtil::ECS_STATUS_SHUTDOWN,
                'dns_bind' => EcsUtil::ECS_DNS_STATUS_UNBIND,
                'sql_in_white_list' => EcsUtil::ECS_MYSQL_STATUS_UNADD,
                'comment' => $_strComment
        ];
        
        return $this->createNew($aryTemp, "ecs创建失败");
    }
    
    /**
     * 修改本地IP
     * 
     * @param number $_intId 数据id
     * @param string $_strLocalIp 局域网Ip
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    public function updateLocalIp($_intId=0, $_strLocalIp="")
    {
        $this->setScenario("local_ip");
        $this->updateById($_intId, ['local_ip'=>$_strLocalIp], "局域网IP修改失败");
    }
    
    /**
     * 修改网络IP
     * 
     * @param number $_intId
     * @param string $_strNetIp
     *
     * @author xiaoyi
     * @date 2016年10月16日
     */
    public function updateNetIp($_intId=0, $_strNetIp="")
    {
        $this->setScenario("net_ip");
        $this->updateById($_intId, ['net_ip'=>$_strNetIp], "网络IP修改失败");
    }
    
    
}
