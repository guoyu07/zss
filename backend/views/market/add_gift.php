<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
 <!-- 引入时间的文件 -->
	  <script src="./assets/order/laydate/laydate.js"></script>	  
	  <div class="widget-box" style=" height:600px; ">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>添加赠品</h5>
        </div>
        <div class="widget-content nopadding">

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => ['class' => 'form-horizontal'],
	]) ?>    
	
		 
			<div class="control-group">
			 <label class='control-label'>赠品名称</label>
			  <div class='controls'>
			<?= $form->field($model, 'gift_name')->textInput(["style"=>" width:300px; height:35px;"])->label(false) ?>
			  </div>
			</div>   
			
			<div class="control-group">
			 <label class='control-label'>赠品单价</label>
			  <div class='controls'>
			<?= $form->field($model, 'gift_price')->textInput(["style"=>" width:300px; height:35px;"])->label(false) ?>
			  </div>
			</div>   

			<div class="control-group">
			 <label class='control-label'>赠品库存</label>
			  <div class='controls'>
			<?= $form->field($model, 'gift_num')->textInput(["style"=>" width:300px; height:35px;"])->label(false) ?>
			  </div>
			</div>   



			<div class="control-group">
			 <label class="control-label">是否显示:</label>
			  <div class="controls">
			  <select  name="gift_show" style="height:30px;width:100px;" onchange="changeLimit(this.value)">
				<option value="1">是</option>
				<option value="0">否</option>
			  </select>
			</div>  
			</div>


			<div class="control-group" style="width:400px">
			 <label class="control-label">截止时间 :</label>
			  <div class='controls' >
				<?= $form->field($model, 'end_at',['inputOptions'=>['placeholder'=>"输入结束日期","onclick"=>"laydate()"]])->textInput(["style"=>" width:300px; height:35px;","id"=>"end_time"])->label(false) ?>
			  </div>
			</div>



			<div class="form-actions" style=" margin-left:190px; ">
              <button type="submit" class="btn btn-success">添加赠品</button>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>


<script type="text/javascript">

	$("form").submit(function(){
		var nowdate = $("#end_time").val();//获取选中的日期
		var newstr = nowdate.replace(/-/g,'/'); 
		var date =  new Date(newstr); 
		var time_str = date.getTime().toString();//获取到的日期的时间戳
		var timestamp = Date.parse(new Date());
		alert(time_str+","+timestamp)
			if(timestamp > time_str){
				return false;
			}else{
				return true;
			}
		
	});

</script>