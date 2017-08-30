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
          <h5>修改赠品</h5>
        </div>
        <div class="widget-content nopadding">

	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => ['class' => 'form-horizontal'],
	]) ?>    
	
		 
			<div class="control-group">
			 <label class='control-label'>赠品名称</label>
			  <div class='controls'>
			<?= $form->field($model, 'gift_name')->textInput(["style"=>" width:300px; height:35px;","value"=>$oneInfo->gift_name,"class"=>"name"])->label(false) ?>
			<span id="error"></span>
			  </div>
			</div>   
			<input type="hidden" name="id" value="<?php echo $oneInfo->gift_id;?>"/>
			<div class="control-group">
			 <label class='control-label'>赠品单价</label>
			  <div class='controls'>
			<?= $form->field($model, 'gift_price')->textInput(["style"=>" width:300px; height:35px;","value"=>floor($oneInfo->gift_price)])->label(false) ?>
			  </div>
			</div>   

			<div class="control-group">
			 <label class='control-label'>赠品库存</label>
			  <div class='controls'>
			<?= $form->field($model, 'gift_num')->textInput(["style"=>" width:300px; height:35px;","value"=>$oneInfo->gift_num])->label(false) ?>
			  </div>
			</div>   



			<div class="control-group">
			 <label class="control-label">是否显示:</label>
			  <div class="controls">
			  <select  name="gift_show" style="height:30px;width:100px;" onchange="changeLimit(this.value)">
				<?php if($oneInfo->gift_show==1){?>
				<option value="1" selected>是</option>
				<option value="0">否</option>
				<?php }?>
				<?php if($oneInfo->gift_show==0){?>
				<option value="1">是</option>
				<option value="0" selected>否</option>
				<?php }?>
			  </select>
			</div>  
			</div>


			<div class="control-group" style="width:400px">
			 <label class="control-label">截止时间 :</label>
			  <div class='controls' >
				<?= $form->field($model, 'end_at',['inputOptions'=>['placeholder'=>"输入结束日期","onclick"=>"laydate()"]])->textInput(["style"=>" width:300px; height:35px;","value"=>date("Y-m-d",$oneInfo->end_at)])->label(false) ?>
			  </div>
			</div>



			<div class="form-actions" style=" margin-left:190px; ">
              <button type="submit" class="btn btn-success">修改赠品</button>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>


<script type="text/javascript">

//判断红包名称
function check(name,id){
	flag = 1;
	$.ajax({
	   type: "GET",
	   url: "<?= Yii::$app->urlManager->createUrl(['market/check-gift']); ?>",
	   data: "name="+name+"&id="+id,
	   async:false, 
	   success: function(msg){
			if(msg['code']==400){
				flag = 0;
			}
	   }
	});
	return flag;
}
$("form").submit( function () {
	name = $(".name").val();
	id = $("input[name=id]").val();
	msg = check(name,id);
	if(msg){
		$("#error").html("");
		return true;
	}else{
		$("#error").html("<font color=red>赠品名称不能重复</font>");
		return false;
	}
} );
</script>