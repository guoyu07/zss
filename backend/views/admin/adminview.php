<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>会员添加</h5>
        </div>
        <div class="widget-content nopadding"  style="margin-left:30px;">
             <?php $form = ActiveForm::begin(); ?>
          <!--<form class="form-horizontal" method="post" action="index.php?r=user/verimember">-->
              <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
            <div class="control-group">
             <!-- <label class="control-label">名称 :</label>
              <div class="controls">
                <input type="text"  name='user_name' style='height:25px;' />
               </div>   -->
               <div class="controls">
                 <?= $form->field($model, 'username')->textInput(['style' => 'width:300px;height:35px'])->label('用户名称 :',['class' => 'control-label']) ?> 
               </div>
            </div>
            <div class="control-group">
              <!--<label class="control-label">手机号 :</label>
              <div class="controls">
                <input type="text"   name='user_phone'  style='height:25px;'/> 
              </div>-->
                 <?= $form->field($model, 'email')->textInput(['style' => 'width:300px;height:35px'])->label('邮箱 :') ?>
            </div>
            <div class="control-group">
              <!--<label class="control-label">密码</label>
              <div class="controls">
                <input type="text"   name='user_password'  style='height:25px;'/>   </div>  -->
              
            <?= $form->field($model, 'auth_key')->passwordInput(['style' => 'width:300px;height:35px'])->label('密码 :') ?>
            </div>
              <div class="control-group">
              <!--<label class="control-label">密码</label>
              <div class="controls">
                <input type="text"   name='user_password'  style='height:25px;'/>   </div>  -->
              
            <?= $form->field($model, 'user_repassword')->passwordInput(['style' => 'width:300px;height:35px'])->label('确认密码 :') ?>
            </div>
         
            <div class="form-actions">
              <button class="btn btn-success" type="submit">Save</button>
            </div>
        <?php ActiveForm::end(); ?>
        </div>
      </div>
