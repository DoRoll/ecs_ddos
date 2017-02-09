<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disk".
 *
 * @property integer $id
 * @property string $disk_id
 * @property integer $type
 * @property integer $create_at
 * @property integer $update_at
 */
class Disk extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TABLE_PREFIX.'disk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at'], 'integer'],
            [['disk_id'], 'string', 'max' => 32]
        ];
    }
    
    /**
     * 返回惟一实例
     *
     * @return Disk     
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
        return $parent;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'disk_id' => 'Disk ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
    
    public function getDiskList()
    {
        return $this->find()->select(['disk_id', 'type'])->asArray()->all();
    }
}
