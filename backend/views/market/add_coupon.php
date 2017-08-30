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
          <h5>添加优惠券</h5>
        </div>
        <div class="widget-content nopadding">
	<?php $form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => ['class' => 'form-horizontal'],
	]) ?>   
			<div class="control-group">
			 <label class='control-label'>优惠券名称</label>
			  <div class='controls'>

				<?= $form->field($model, 'coupon_name',['inputOptions'=>['placeholder'=>"请输入优惠券名称"]])->textInput(["style"=>" width:300px; height:35px;"])->label(false) ?>

			  </div>
			</div>
			
		
		
			<div class="control-group">
			 <label class='control-label'>可抵用：</label>
			  <div class='controls'>
				<?= $form->field($model, 'coupon_price',['inputOptions'=>['placeholder'=>"请输入抵用金额"]])->textInput(["style"=>" width:300px; height:35px;"])->label(false) ?>
			  </div>
			</div>


			<div class="control-group">
			 <label class="control-label">是否显示 :</label>
			  <div class="controls">
			  <select name="coupon_show" style="height:30px;width:100px;">
				<option value="1">是</option>
				<option value="0">否</option>
			  </select>
			</div>  
			</div>


			<div class="control-group" style="width:400px">
			 <label class="control-label">截止时间 :</label>
			  <div class='controls' >
				<?= $form->field($model, 'end_time',['inputOptions'=>['placeholder'=>"输入结束日期","onclick"=>"laydate()"]])->textInput(["style"=>" width:300px; height:35px;","id"=>"end_time"])->label(false) ?>
			  </div>
			</div>



			<div class="control-group">
			 <label class="control-label">选择分类 :</label>
			  <div class="controls">
			  <select name="coupon_type" style="height:30px;width:100px;" onchange="getType(this.value)">
				<option value="1">菜品</option>
				<option value="2">分类</option>
				<option value="3">全部</option>
			  </select>
			</div>  
			</div>

			<div class="control-group" id="allType">
			 <label class="control-label">选择优惠列表 :</label>
			  <div class="controls">
			 <div style="width:200px;height:200px;overflow:scroll;border:solid #ccccff" class="menu">
				<?php
					foreach($menuList as $k=>$v){
						echo "<p>"."<input type='checkbox' value=".$v['menu_id']." name='list1[]'>".$v['menu_name']."</p>";
					}
				
				?>
				
			 </div>
				
			 <div style="width:200px;height:200px;overflow:scroll;border:solid #ccccff;display:none" class="series">
				<?php
					foreach($seriesList as $k=>$v){
						echo "<p>"."<input type='checkbox' value=".$v['series_id']." name='list2[]'>".$v['series_name']."</p>";
					}
				
				?>
			 </div>
			 </div>  
			</div>


              <button type="submit" class="btn btn-success" id="btn" style=" margin-left:190px; ">添加优惠券</button>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
</body>

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

	//按钮事件
	$("form").submit(function(){
		var len1 = $("input[name='list1[]']").length;
		var len2 = $("input[name='list2[]']").length;
		var lenAll = len1+len2;
		var nowdate = $("#end_time").val();//获取选中的日期
		var newstr = nowdate.replace(/-/g,'/'); 
		var date =  new Date(newstr); 
		var time_str = date.getTime().toString();//获取到的日期的时间戳
		var timestamp = Date.parse(new Date());

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
			if(timestamp > time_str){
				return false;
			}
			else if(lenAll == str1){
				return false;
			}else{
				return true;
			}
		
	});
</script>