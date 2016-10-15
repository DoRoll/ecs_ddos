<?php
namespace app\controllers;

use yii\web\Controller;
use Yii;

class BaseController extends Controller
{
    public function init()
    {
        parent::init();
        if(Yii::$app->user->isGuest )
        {
            $url = Yii::$app->request->getUrl();
            $this->redirect('/site/index');
        }
    }
}