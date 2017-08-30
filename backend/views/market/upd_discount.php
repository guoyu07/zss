<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
	  
	  <div class="widget-box" style=" height:600px; ">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>修改折扣：</h5>
        </div>
        <div class="widget-content nopadding">
		<?php $form = ActiveForm::begin([
			'id' => 'login-form',
			'options' => ['class' => 'form-horizontal'],
		]) ?>     

			<div class="control-group">
			 <label class='control-label'>输入折扣</label>
			  <div class='controls'>

			<?= $form->field($model, 'discount_num',['inputOptions'=>['placeholder'=>"请输入折扣"]])->textInput(["style"=>" width:300px; height:35px;","value"=>$oneInfo->discount_num])->label(false) ?>
			  </div>
			</div>   

			<div class="control-group">
			 <label class="control-label">是否显示 :</label>
			  <div class="controls">
			  <select name="discount_show" style="height:30px;width:100px;" onchange="changeLimit(this.value)">
				<?php if($oneInfo->discount_show == 1){?>
				<option value = 1 selected>是</option>
				<option value = 0>否</option>
				<?php 
				}else{
				?>
				<option value = 1>是</option>
				<option value = 0 selected>否</option>
				<?php }?>
			  </select>
			</div>  
			</div>
            
           
            <div class="form-actions" style=" margin-left:250px; ">
			  <? echo Html::submitButton('修改折扣', ['class'=>'btn btn-success']) ?>
            </div>
         <?php ActiveForm::end(); ?>
        </div>
      </div>