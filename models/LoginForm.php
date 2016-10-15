<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }
    
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '密码不正确');
            }
        }
    }

    public function login()
    {
        if ($this->validate())
        {
            $objUser = $this->getUser();
            if($objUser->status == -1)
            {
                $this->addError("username", "账户已经被禁用");
                return false;
            }
            
            $objUser->setScenario("login");
            $objUser->generateAuthKey();
            $objUser->ip = Yii::$app->request->getUserIP();
            $objUser->update_at = time();
            $objUser->save();
            
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
    
    public function attributeLabels()
    {
        return [
                'username' => '用户名',
                'password' => '密码',
                'rememberMe' => '记住我',
        ];
    }
}
