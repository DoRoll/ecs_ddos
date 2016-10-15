<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '触动ECS中心',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $aryMenu[] = ['label' => 'ECS管理',
                'items' => [
                        ['label' => '创建ECS', 'url' => ['/ecs/create']],
                        ['label' => '删除ECS管理', 'url' => ['/ecs/delete']],
                ]];
    if(Yii::$app->user->isGuest)
    {
        $aryMenu[] = ['label' => 'Login', 'url' => ['/site/login']];
    }
    else
    {
        $aryMenu[] = ['label' => Yii::$app->user->identity->username,
                     'items' => [
                         ['label' => '用户信息', 'url' => ['/site/logout']],
                         ['label' => '修改密码', 'url' => ['/site/logout']],
                         ['label' => '退出登入', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
                    ],
        ];
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $aryMenu,
    ]);
    NavBar::end();
    ?>

    <div class="container" style="padding-top: 100px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 北京帮你玩科技有限公司 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
