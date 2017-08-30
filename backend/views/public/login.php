<!DOCTYPE html>
<html lang="zh-CN">
<?php
use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
$this->title = '登陆界面';

LoginAsset::register($this);
LoginAsset::addPageScript($this, 'assets/js/login.js');
?>
<head>
<meta charset="<?= Yii::$app->charset ?>">
<title><?= Html::encode($this->title) ?></title>
</head>
<body>
	<div class="top_div"></div>
	<div class="login-warp">
		<!--顶部小人-->
		<div class="happy">
			<div class="tou"></div>
			<div class="initial_left_hand" id="left_hand"></div>
			<div class="initial_right_hand" id="right_hand"></div>
		</div>
		<!--登录输入框-->
		<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
			<div class="login">
                <!--用户名-->
                <?= $form->field($model, 'username', 
                [
                    'inputOptions' => ['placeholder'=>'请输入用户名', 'class' => 'ipt'],
                    'template' => '<p><span class="u_logo"></span>{input}</p>{error}',
                ])->textInput() 
                ?>


                <!--密码-->
                <?= $form->field($model, 'password',
                [
                    'inputOptions' => ['placeholder'=>'请输入密码', 'class' => 'ipt'],
                    'template' => '<p><span class="p_logo"></span>{input}</p>{error}',
                ])->passwordInput() ?>
				
                <!--验证码-->
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(),[
				   'template' => '<p class="iPhone-num">{image}<span class="img-num">{input}</span></p>',
				   'imageOptions' => ['alt' => '验证码'],
				   'captchaAction' => 'public/captcha',
                   'options' =>['placeholder' => '请输入验证码', 'class' => 'ipt'],
				]);?>
			</div>
			<!--登录按钮-->
			<div class="login-btn">
				<?= Html::resetButton('重置', ['class' => 'btnX', 'name' => 'reset-button']) ?>
				<?= Html::submitButton('登陆', ['class' => 'btnY', 'name' => 'login-button']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
	<!--footer-->
	<div id="footer">
		<p>
			<span>北京宅食送科技有限公司<br>© 2016
			</span>
		</p>
	</div>
</body>
</html>



<div class="panel-body">

	
</div>