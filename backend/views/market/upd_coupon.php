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
          <h5>修改优惠券</h5>
        </div>
        <div class="widget-content nopadding">
 
<?php $form = ActiveForm::begin([
	'method' => 'post',
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
		

<div class="control-group">
 <label class='control-label'>优惠券名称</label>
  <div class='controls'>

	<?= $form->field($model, 'coupon_name',["inputOptions"=>["value"=>$oneInfo->coupon_name]])->textInput([
	"style"=>"width:300px; height:35px"])->label(false) ?>

  </div>
</div>
			

		
			<div class="control-group">
			 <label class='control-label'>可抵用：</label>
			  <div class='controls'>
				<?= $form->field($model, 'coupon_price',['inputOptions'=>['placeholder'=>"请输入抵用金额"]])->textInput(["style"=>" width:300px; height:35px;","value"=>floor($oneInfo->coupon_price)])->label(false) ?>
			  </div>
			</div>


			<div class="control-group">
			 <label class="control-label">是否显示 :</label>
			  <div class="controls">
			  <select name="coupon_show" style="height:30px;width:100px;">
			  <?php if($oneInfo->coupon_show == 1){?>
				<option value="1" selected>是</option>
				<option value="0">否</option>
				<?php }else{
				?>
				<option value="1">是</option>
				<option value="0" selected>否</option>
				<?php
					}
				?>
			  </select>
			</div>  
			</div>

			<div class="control-group" style="width:400px">
			 <label class="control-label">截止时间 :</label>
			  <div class='controls' >
				<?= $form->field($model, 'end_time',['inputOptions'=>['placeholder'=>"输入结束日期","onclick"=>"laydate()"]])->textInput(["style"=>" width:300px; height:35px;","value"=>date("Y-m-d",$oneInfo->end_at)])->label(false) ?>
			  </div>
			</div>

			<div class="control-group">
			 <label class="control-label">选择分类 :</label>
			  <div class="controls">
			  <select name="coupon_type" style="height:30px;width:100px;" id="coupon_type" onchange="getType(this.value)">
				<?php if($oneInfo->menu_id == 'all' and $oneInfo->coupon_type == 'all'){?>
					<option value="1">菜品</option>
					<option value="2">分类</option>
					<option value="3" selected>全部</option>
				<?php }?>

				<?php if(empty($oneInfo->menu_id)){?>
					<option value="1">菜品</option>
					<option value="2" selected>分类</option>
					<option value="3">全部</option>
				<?php }?>

				<?php if(empty($oneInfo->coupon_type)){?>
					<option value="1" selected>菜品</option>
					<option value="2">分类</option>
					<option value="3">全部</option>
				<?php }?>
				</select>
			</div>  
			</div>

			<div class="control-group" id="allType">
			 <label class="control-label">选择优惠列表 :</label>
			  <div class="controls">
			 <div style="width:200px;height:200px;overflow:scroll;border:solid #ccccff" class="menu">
				<?php
					$menu_list = explode(",",$oneInfo->menu_id);
					
					foreach($menuList as $k=>$v){
						
						if(in_array($v['menu_id'],$menu_list)){
							echo "<p>"."<input type='checkbox' checked='checked' value=".$v['menu_id']." name='list1[]'>".$v['menu_name']."</p>";
						}else{
							echo "<p>"."<input type='checkbox' value=".$v['menu_id']." name='list1[]'>".$v['menu_name']."</p>";
						}
					}
				
				?>
				
			 </div>
				
			 <div style="width:200px;height:200px;overflow:scroll;border:solid #ccccff;display:none" class="series">
				<?php

					$type_list = explode(",",$oneInfo->coupon_type);

					foreach($seriesList as $k=>$v){
						if(in_array($v['series_id'],$type_list)){
							echo "<p>"."<input type='checkbox' checked='checked' value=".$v['series_id']." name='list2[]'>".$v['series_name']."</p>";
						}else{
							echo "<p>"."<input type='checkbox' value=".$v['series_id']." name='list2[]'>".$v['series_name']."</p>";
						}
					}
				
				?>
			 </div>
			
			 </div>  
			</div>


			<div class="form-actions" style=" margin-left:190px; ">
              <button type="submit" class="btn btn-success">修改优惠券</button>
            </div>

<?php ActiveForm::end() ?>


        </div>
      </div>


<script type="text/javascript">
	
	//选择不同的分类
	function getType(type){
		if(type == 1){
			$("#allType").show();
			$(".menu").show();
			$(".series").hide();
		}
		if(type == 2){
			$("#allType").show();
			$(".series").show();
			$(".menu").hide();
		}
		if(type == 3){
			$("#allType").hide();
		}
	}


	//页面加载事件
	$(document).ready(function(){

		var type_id = $("#coupon_type option:selected").val();
			if(type_id == 1){
				$("#allType").show();
				$(".menu").show();
				$(".series").hide();
			}
			if(type_id == 2){
				$("#allType").show();
				$(".series").show();
				$(".menu").hide();
			}
			if(type_id == 3){
				$("#allType").hide();
			}

	});


	$("form").submit(function(){
		type = $('#coupon_type option:selected') .val();

		var len1 = $("input[name='list1[]']").length;
		var len2 = $("input[name='list2[]']").length;
		var lenAll = len1+len2;
		var str1 = 0;
		  $("input[name='list1[]']:checkbox").each(function(){
			if(!$(this).attr('checked')){ 
				 str1++;
				 } 
			});
		  $("input[name='list2[]']:checkbox").each(function(){
			if(!$(this).attr('checked')){ 
				 str1++;
				 } 
			});
			if(type == 3){
				return true;
			}else if(lenAll == str1){
				return false;
			}else{
				return true;
			}
	});
</script>