<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ecs_config".
 *
 * @property integer $id
 * @property string $zone
 * @property string $zone_id
 * @property string $image_id
 * @property string $instance_type
 * @property string $security_group_id
 * @property string $instance_name
 * @property string $description
 * @property string $internet_charge_type
 * @property integer $internet_max_bandwidth_out
 * @property string $host_name
 * @property string $password
 * @property string $io_optimized
 * @property string $system_disk_category
 * @property integer $system_disk_size
 * @property string $system_disk_diskname
 * @property string $system_disk_description
 * @property string $instance_charge_type
 * @property integer $create_at
 * @property integer $update_at
 * @property string $comment
 * @property string $rds
 */
class EcsConfig extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TABLE_PREFIX.'ecs_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['internet_max_bandwidth_out', 'system_disk_size', 'create_at', 'update_at'], 'integer'],
            [['zone_id', 'image_id', 'instance_type', 'security_group_id', 'system_disk_category', 
                'instance_charge_type'], 'string', 'max' => 32],
            [['instance_name', 'description', 'internet_charge_type', 'host_name', 'password', 
                'io_optimized', 'system_disk_diskname', 'system_disk_description', 'comment'], 
                'string', 'max' => 255]
        ];
    }
    
    /**
     * 返回惟一实例
     *
     * @return EcsConfig
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
            'zone' => 'zone',
            'zone_id' => 'Zone ID',
            'image_id' => 'Image ID',
            'instance_type' => 'Instance Type',
            'security_group_id' => 'Security Group ID',
            'instance_name' => 'Instance Name',
            'description' => 'Description',
            'internet_charge_type' => 'Internet Charge Type',
            'internet_max_bandwidth_out' => 'Internet Max Bandwidth Out',
            'host_name' => 'Host Name',
            'password' => 'Password',
            'io_optimized' => 'Io Optimized',
            'system_disk_category' => 'System Disk Category',
            'system_disk_size' => 'System Disk Size',
            'system_disk_diskname' => 'System Disk Diskname',
            'system_disk_description' => 'System Disk Description',
            'instance_charge_type' => 'Instance Charge Type',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'comment' => 'Comment',
        ];
    }
}
