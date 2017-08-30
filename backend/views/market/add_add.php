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
          <h5>添加满赠</h5>
        </div>
        <div class="widget-content nopadding">

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => ['class' => 'form-horizontal'],
	]) ?>    
	
		 
			<div class="control-group">
			 <label class='control-label'>满</label>
			  <div class='controls'>

			<?= $form->field($model, 'add_price')->textInput(["style"=>" width:300px; height:35px;"])->label(false) ?>
			  </div>
			</div>   
			
			
            <div class="control-group">
              <label class="control-label">满赠 :</label>
              <div class="controls">
                  <select  name='gift' style='height:25px;width:100px;'>
                      <?php foreach($giftList as $models){?>
                        <option value='<?= Html::encode($models['gift_id']);?>'><?= Html::encode($models['gift_name']);?></option> 
                      <?php }?>
                  </select>
              </div>
            </div>

			<div class="control-group">
			 <label class="control-label">是否显示:</label>
			  <div class="controls">
			  <select  name="add_show" style="height:30px;width:100px;" onchange="changeLimit(this.value)">
				<option value="1">是</option>
				<option value="0">否</option>
			  </select>
			</div>  
			</div>


			<div class="form-actions" style=" margin-left:190px; ">
              <button type="submit" class="btn btn-success">添加满赠</button>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>


<script type="text/javascript">


</script>