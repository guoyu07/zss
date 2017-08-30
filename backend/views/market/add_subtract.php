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
          <h5>添加满减</h5>
        </div>
        <div class="widget-content nopadding">

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => ['class' => 'form-horizontal'],
	]) ?>     

		  <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
           

			<div class="control-group">
			 <label class='control-label'>满</label>
			  <div class='controls'>

			<?= $form->field($model, 'subtract_price')->textInput(["style"=>" width:300px; height:35px;","id"=>"subtract_full"])->label(false) ?>
			  </div>
			</div>   

			<div class="control-group">
			 <label class='control-label'>减</label>
			  <div class='controls'>
			<?= $form->field($model, 'subtract_subtract')->textInput(["style"=>" width:300px; height:35px;","id"=>"subtract_subtract"])->label(false) ?> 
			<span id="error"></span>

			  </div>
			</div>   

          

			<div class="control-group">
			 <label class="control-label">是否显示:</label>
			  <div class="controls">
			  <select  name="discount_show" style="height:30px;width:100px;" onchange="changeLimit(this.value)">
				<option value="1">是</option>
				<option value="0">否</option>
			  </select>
			</div>  
			</div>


			<div class="form-actions" style=" margin-left:190px; ">
              <button type="submit" class="btn btn-success">添加满减</button>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>


<script type="text/javascript">

	//失去焦点时计算被分享者得到的金额
	$("#subtract_subtract").blur(function(){
		
		full = $("#subtract_full").val();
		subtract = $("#subtract_subtract").val();
		cha = full-subtract;
		alert(cha)
		if(cha>0){
			$(".btn").attr("disabled",false)
		}else if(cha==0){
				$("#error").html("<font color=red>不可以相同</font>");
		}else if(cha<0){
				$("#error").html("<font color=red>满值不能小于减值</font>");
		}else{
			$("#error").html("<font color=red>输入值有误无法计算</font>");
			$(".btn").attr("disabled",true)
		}
	});</script>