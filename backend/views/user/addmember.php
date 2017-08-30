<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<style>
label{display:none}    
</style>
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>会员添加</h5>
        </div>
        <div class="widget-content nopadding"  style="margin-left:30px;">
             <?php $form = ActiveForm::begin(); ?>
          <!--<form class="form-horizontal" method="post" action="index.php?r=user/verimember">-->
              <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
              <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体;text-align:center;">
                  <tr>
                      <td><span ><b>用户名称 :</b></span></td><td><?= $form->field($model, 'user_name')->textInput(['style' => 'width:300px;height:35px']) ?>  </td>
                  </tr> 
                   <tr>
                      <td><span ><b>性别 :</b></span></td><td>    
             <?= $form->field($model, 'user_sex')->dropDownList(['男' => '男', '女' => '女', '保密' => '保密'],['style' => 'width:300px;height:35px']) ?> </td>
                  </tr> 
                   <tr>
                      <td><span ><b>手机号 :</b></span></td><td> <?= $form->field($model, 'user_phone')->textInput(['style' => 'width:300px;height:35px'])?> </td>
                  </tr>
                  <tr>
                      <td><span ><b>密码 :</b></span></td><td><?= $form->field($model, 'user_password')->passwordInput(['style' => 'width:300px;height:35px']) ?></td>
                  </tr>
                  <tr>
                      <td><span ><b>确认密码 :</b></span></td><td>  <?= $form->field($model, 'user_repassword')->passwordInput(['style' => 'width:300px;height:35px']) ?></td>
                  </tr> 
                   <tr>
                      <td><span ><b>用户余额 :</b></span></td><td> <?= $form->field($model, 'user_price')->textInput(['style' => 'width:300px;height:35px'])?></td>
                  </tr> 
                   <tr>
                      <td><span ><b>用户积分 :</b></span></td><td>    <?= $form->field($model, 'user_virtual')->textInput(['style' => 'width:300px;height:35px']) ?> </td>
                  </tr> 
                  <!--  <tr>
                      <td><span ><b>会员等级 :</b></span></td>
                      <td>  
                      <select  name='vip_id' style='height:35px;width:100px;'>
                      <?php foreach($vip as $models){?>
                        <option value='<?= Html::encode($models['vip_id']);?>'><?= Html::encode($models['vip_name']);?></option> 
                      <?php }?>
                      </select>
                      </td>
                  </tr> -->
                    <tr>
                      <td><span ><b>公司 :</b></span></td>
                      <td> 
                          <select  name='company_id' style='height:35px;width:100px;'>
                              <option value="">请选择</option>
                      <?php foreach($company as $models){?>
                        <option value='<?= Html::encode($models['company_id']);?>'><?= Html::encode($models['company_name']);?></option> 
                      <?php }?>
                  </select> 
                      </td>
                  </tr> 
                  <tr>
                      <td> <button class="btn btn-success" type="submit">添加</button></td>
                  </tr>
                  
              </table>
            
          
          </form>
        </div>
</div>
