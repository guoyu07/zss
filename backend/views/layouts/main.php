<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?= Html::jsFile('/assets/1902591f/jquery.js')?>
    <?= Html::cssFile('/css/upload.css')?>
    <?= Html::cssFile('/css/personal.css')?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '管理后台',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $menuItemLeft = [];
    //判断权限,左侧菜单
    /*if ($access = Yii::$app->params['access']) {
        isset($access['USER']['INDEX']) && $menuItemLeft[] = ['label' => '用户', 'url' => ['/user/index']];
        isset($access['COURSE']['INDEX']) && $menuItemLeft[] = ['label' => '课程', 'url' => ['/course/index']];
        isset($access['OPERATE']['INDEX']) && $menuItemLeft[] = ['label' => '运营', 'url' => ['/operate/index']];
        isset($access['ORDER']['INDEX']) && $menuItemLeft[] = ['label' => '订单', 'url' => ['/order/index']];
        isset($access['COIN']['INDEX']) && $menuItemLeft[] = ['label' => '账务', 'url' => ['/coin/index']];
        isset($access['DOWNLOAD']['INDEX']) && $menuItemLeft[] = ['label' => '下载', 'url' => ['/download/index']];
        isset($access['FRIEND']['INDEX']) && $menuItemLeft[] = ['label' => '用户关系', 'url' => ['/friend/index']];
        isset($access['SYSTEM']['INDEX']) && $menuItemLeft[] = ['label' => '系统', 'url' => ['/system/index']];
    } else {*/
        $menuItemLeft = [
            ['label' => '用户', 'url' => ['/user/index']],
            ['label' => '菜单', 'url' => ['/menu/index']],
            ['label' => '门店', 'url' => ['/shop/index']],
            ['label' => '订单', 'url' => ['/order/index']],
            ['label' => '营销', 'url' => ['/market/index']],
            ['label' => '运营', 'url' => ['/operate/index']],
            ['label' => '系统', 'url' => ['/system/index']],
        ];
    //}
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItemLeft,
    ]);
    
    //右侧菜单
    $menuItemRight = [
        ['label' => '常用', 'url' => 'javascript:void(0);'],
        ['label' => '回到首页', 'url' => ''],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItemRight[] = ['label' => '登陆', 'url' => ['/public/login']];
    } else {
        $menuItemRight[] = [
            'label' => '退出 (' . Yii::$app->user->identity->username . ')',
            'url' => ['/public/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItemRight,
    ]);

   
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?> <!--警报组件-->
        <?= $content ?>
        <?= Html::csrfMetaTags() ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 北京宅食送科技有限公司 <?= date('Y') ?></p>

        <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
    </div>
</footer>
<?php $this->registerJs('setTimeout(function(){$(".alert").fadeOut(3000)},5000)') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>