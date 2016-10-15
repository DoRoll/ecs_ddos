<?php

namespace app\models;

use yii\web\NotFoundHttpException;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "ts_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $mobile
 * @property string $real_name
 * @property string $alipay
 * @property string $ip
 * @property integer $status
 * @property string $spread
 * @property integer $role
 * @property integer $create_at
 * @property integer $update_at
 * @property string $authKey
 */
class User extends BaseModel implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TABLE_PREFIX.'user';
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
                [['password', 'alipay', 'authKey'], 'string', 'max' => 64],
                [['mobile'], 'string', 'max' => 11],
                ['verifyCode', 'captcha'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                'id' => 'ID',
                'username' => '用户名',
                'password' => '密码',
                'mobile' => 'Mobile',
                'real_name' => 'Real Name',
                'alipay' => 'Alipay',
                'ip' => 'Ip',
                'status' => 'Status',
                'spread' => 'Spread',
                'role' => 'Role',
                'create_at' => 'Create At',
                'update_at' => 'Update At',
        ];
    }
    
    public function scenarios()
    {
        $parent = parent::scenarios();
        $parent['login'] = ['authKey', 'ip', 'udpate_at'];
        return $parent;
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotFoundHttpException("页面未找到");
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username'=>$username]);
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    
    public function generateAuthKey()
    {
        return $this->authKey = Yii::$app->security->generateRandomString();
    }
}
