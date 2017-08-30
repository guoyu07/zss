<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
$this->params['breadcrumbs'][] = ['label' => $model->role_id, 'url' => ['roleupdate', 'id' => $model->role_id]];
?>


<div class="widget-box" style="width:600px">
         <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
         <h5>修改列表</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
    </div>
</div>

 <div style="height:150px;width:600px">
          
				<?php 
					$form = ActiveForm::begin([
						'options' => ['class' => 'form-horizontal',
						'id'=>'Users-form'],
						'action'=>Url::to(['admin/rolecreate']),
						'method'=>'post'
					]);
				?>
				<?= $form->field($model, 'role_id', ['template'=>'<div class="form-group"><div class="col-md-8 controls">{input}{error}</div></div>'])->hiddenInput() ?>
				 <table align="center">
              <tr>	
                  <td>名称:</td><td><?= $form->field($model, 'role_name',['inputOptions'=>['placeholder'=>'请输入角色名称']])->textInput(['maxlength' => true,"style"=>"height:35px;"]) ?></td>
              </tr>	
              <tr>	
                  <td>状态:</td>
				  <td>	
					<input type="radio" name="AuthRole[role_status]" checked value=1>开启
					<input type="radio" name="AuthRole[role_status]" value=0>禁用
				</td>
              </tr>
			  <tr>
				<td>信息名称：</td>
				<td>
				<?= $form->field($model, 'role_remark',['inputOptions'=>['placeholder'=>'请输入角色信息名称']])->textInput(['maxlength' => true,"style"=>"height:35px;"]) ?>
				</td>
			  </tr>
				<br>
				<tr>	
					<td></td>
                    <td >
					<?= Html::submitButton('保存', ['class' => 'btn btn-primary','id'=>'user-create-btn']) ?></td><td></td>
                 </tr>			
				 </table>
				<?php ActiveForm::end(); ?>
                               	
  </div>