<?php

namespace app\models;

use Yii;
use app\lib\Util;

/**
 * This is the model class for table "snapshot".
 *
 * @property integer $id
 * @property string $batch
 * @property string $snapshot_id
 * @property string $disk_id
 * @property integer $status
 * @property integer $day_at
 * @property integer $create_at
 * @property integer $update_at
 */
class Snapshot extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TABLE_PREFIX.'snapshot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at'], 'default', 'value'=>time()],
            ['day_at', 'default', 'value'=>Util::mathDayTime()],
            [['status', 'day_at', 'create_at', 'update_at'], 'integer'],
            [['batch'], 'string', 'max' => 6],
            [['snapshot_id', 'disk_id'], 'string', 'max' => 32]
        ];
    }
    
    /**
     * 返回惟一实例
     *
     * @return Snapshot     
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
        $parent['create'] = ['batch', 'snapshot_id', 'disk_id', 'status', 'day_at', 'create_at', 'update_at'];
        $parent['compile'] = ['status', 'update_at'];
        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch' => 'Batch',
            'snapshot_id' => 'Snapshot ID',
            'disk_id' => 'Disk ID',
            'status' => 'Status',
            'day_at' => 'Day At',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
    
    /**
     * 创建一条数据
     * 
     * @param array $_aryParam 数据源
     *
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function addNew($_aryParam=[])
    {
        return $this->createNew($_aryParam, "磁盘数据创建失败");
    }
    
    /**
     * 快照创建完成
     * 
     * @param number $_intId 快照列表ID
     * @param number $_intStatus 状态
     *
     * @author xiaoyi
     * @date 2016年10月25日
     */
    public function compile($_intId=0, $_intStatus=0)
    {
        $this->setScenario("compile");
        $this->updateById($_intId, ['status'=>$_intStatus], "磁盘状态修改失败");
    }
}
