<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "web_admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $passwd
 * @property string $mobile
 * @property string $real_name
 * @property string $alipay
 * @property string $ip
 * @property integer $status
 * @property integer $role
 * @property integer $create_at
 * @property integer $update_at
 * @property string $spread
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ts_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'status', 'role', 'create_at', 'update_at'], 'integer'],
            [['username', 'real_name', 'ip', 'spread'], 'string', 'max' => 32],
            [['passwd', 'alipay'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'passwd' => 'Passwd',
            'mobile' => 'Mobile',
            'real_name' => 'Real Name',
            'alipay' => 'Alipay',
            'ip' => 'Ip',
            'status' => 'Status',
            'role' => 'Role',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'spread' => 'Spread',
        ];
    }
}
