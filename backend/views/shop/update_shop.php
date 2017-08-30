 <?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '门店信息修改'; 
?>
<style type="text/css">
body{ font-size:15px; background-color:#f9f9f9;}
.control-label{ font-size:16px; font-family: 微软雅黑}
#left{ float:left; border:0px red solid; width:40%; }
#right{  float:left; border:0px red solid;  }
.btn-primary{ width:110px;}
.status{cursor:pointer;}
#allmap {width:100%;height:300px;}
</style>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<!--百度地图产品密钥-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=qsBc7zj8VnjrxUauu2xgwGeX"></script>
<?= Html::cssFile('./assets/order/time/jquery.datetimepicker.css')?>
<?= Html::jsFile('./assets/order/time//jquery.js')?>
<?= Html::jsFile('./assets/order/time/jquery.datetimepicker.js')?>
  <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>门店信息修改</h5>
        </div>

        <div class="widget-content nopadding" >
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

		  <div class="control-group">
              <label class="control-label"><button class="btn btn-primary" disabled>
				门店&nbsp;ID&nbsp;&nbsp;:&nbsp;&nbsp;
				<span id="shop_id"><?= Html::encode($shop['shop_id']); ?></span></button></label>
              <div class="controls" style="font-size:20px; padding-top:15px;">
              </div>
            </div>
			
<!--left start -->
<div id="left">

	<div class="control-group" style="">
	  <label class="control-label"><button class="btn btn-primary" disabled>门店名称</button></label>
	  <div class="controls">
	   <?= $form->field($model, 'shop_name',['inputOptions'=>['value'=>Html::encode($shop['shop_name']),"disabled"=>true]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>
	  <div class="control-group">
		  <label class="control-label"><button class="btn btn-primary" disabled>营业状态</button></label>
		  <div class="controls"  style=" padding-top:15px;">
			<?php if(Html::encode($shop['shop_status'])==1): ?>
				<input type="radio" name="ShopinfoForm[shop_status]" value="1" checked>&nbsp;营业
				&nbsp;&nbsp;
				<input type="radio" name="ShopinfoForm[shop_status]" value="0">&nbsp;关闭
			<?php else: ?>
				<input type="radio" name="ShopinfoForm[shop_status]" value="1">&nbsp;营业
				&nbsp;&nbsp;
				<input type="radio" name="ShopinfoForm[shop_status]" value="0" checked>&nbsp;关闭
			<?php endif; ?>
		  </div>
		</div>
	 <div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>外卖开始时间</button></label>
	  <div class="controls">
		<?= $form->field($model, 'takeaway_start_time',['inputOptions'=>['value'=>Html::encode(date("Y-m-d H:i:s",$shop['takeaway_start_time'])),"id"=>"date1"]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>
	 <div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>外卖结束时间</button></label>
	  <div class="controls" >
		<?= $form->field($model, 'takeaway_end_time',['inputOptions'=>['value'=>Html::encode(date("Y-m-d H:i:s",$shop['takeaway_end_time'])),"id"=>"date2"]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>
	 <div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>堂食开始时间</button></label>
	  <div class="controls">
		<?= $form->field($model, 'eat_start_time',['inputOptions'=>['value'=>Html::encode(date("Y-m-d H:i:s",$shop['eat_start_time'])),"id"=>"date3"]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>
	 <div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>堂食结束时间</button></label>
	  <div class="controls">
		<?= $form->field($model, 'eat_end_time',['inputOptions'=>['value'=>Html::encode(date("Y-m-d H:i:s",$shop['eat_end_time'])),"id"=>"date4"]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>门店经度</button></label>
	  <div class="controls">
		<?= $form->field($model, 'shop_x',['inputOptions'=>['value'=>Html::encode($shop['shop_x']),"class"=>"xx"]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >门店纬度</button></label>
	  <div class="controls">
		<?= $form->field($model, 'shop_y',['inputOptions'=>['value'=>Html::encode($shop['shop_y']),"class"=>"yy"]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >满增</button></label>
	  <div class="controls">
		<?php $model->add_id=$shop['add_id']; echo $form->field($model, 'add_id')->label(false)->dropDownList($zj['add'], ['prompt'=>'请选择','style'=>'width:300px']) ?>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >满减</button></label>
	  <div class="controls">
		<?php $model->subtract_id=$shop['subtract_id']; echo $form->field($model, 'subtract_id')->label(false)->dropDownList($zj['subtract'], ['prompt'=>'请选择','style'=>'width:300px']) ?>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >配送费用</button></label>
	  <div class="controls">
		<?= $form->field($model, 'distribution',['inputOptions'=>['value'=>Html::encode($shop['distribution'])]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >餐盒费用</button></label>
	  <div class="controls">
		<?= $form->field($model, 'lunchbox',['inputOptions'=>['value'=>Html::encode($shop['lunchbox'])]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
	  </div>
	</div>

	

</div>


<!--left end -->
<!--right start -->
<div id="right">

  <div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>门店地址</button></label>
	  <div class="controls">
<?= $form->field($model, 'shop_address',['inputOptions'=>['value'=>Html::encode($shop['shop_address']),"class"=>"addre"]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
<input type="hidden" name="ShopinfoForm[id]" value="<?= Html::encode($id) ?>">
	  </div>
	</div>
	 <div class="control-group">
		  <label class="control-label"><button class="btn btn-primary" disabled>门店电话</button></label>
		  <div class="controls"  style=" padding-top:20px;">
			<?= $form->field($model, 'shop_tel',['inputOptions'=>['value'=>Html::encode($shop['shop_tel'])]])->textInput(["style"=>"width:300px; height:35px; "])->label(false) ?>
		  </div>
		</div>
	<div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>门店类型</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?php foreach($type as $k=>$v): ?>
			<?php if(in_array($v['type_id'],$shop['shop_type'])): ?>
				<input type="checkbox" name="ShopinfoForm[type_id][]" value="<?= Html::encode($v['type_id']); ?>" checked>
			<?php else: ?>
				<input type="checkbox" name="ShopinfoForm[type_id][]" value="<?= Html::encode($v['type_id']); ?>">
			<?php endif; ?>
			<?= Html::encode($v['type_name']); ?>&nbsp;&nbsp;
		<?php endforeach; ?>
	  </div>
	</div>
	<!----百度地图 start ----->
	 <div class="control-group">
	  <label class="control-label"></label>
	  <div class="controls"  style="">
		<div id="allmap"></div>
		<p>点击地图展示详细地址</p>
	  </div>
	</div>
	<!--- 百度地图 end  --->

</div>
<!--right end -->
 
<!--footer start -->
<div style="clear:both">
<div class="control-group">
	<label class="control-label"><button class="btn btn-primary" disabled>备注(通知)</button></label>
	<div class="controls"  style=" padding-top:20px;">
		<!--编辑器 start -->
			<?= $form->field($model, 'shop_remark',["inputOptions"=>["value"=>$shop['shop_remark']]])->textarea(["style"=>"width:700px; height:200px; ","maxlength"=>"200"])->label(false) ?>
		<!-- 编辑器 end -->
	</div>
</div>

<div class="control-group" >
  <label class="control-label"></label>
  <div class="controls">
   <button type="submit" class="btn btn-success">执行修改</button>
  </div>
</div>
</div>
<!-- footer end -->

<?php ActiveForm::end() ?>

	</div>
</div>

<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

<script>
//日历小插件
$('#date1').datetimepicker({value:'',step:10});
$('#date2').datetimepicker({value:'',step:10});
$('#date3').datetimepicker({value:'',step:10});
$('#date4').datetimepicker({value:'',step:10});
//百度地图关
$(document).ready(function(){
	x = $(".xx").val();
	y = $(".yy").val();
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	var point = new BMap.Point(y,x);
	map.centerAndZoom(point,12);
	var geoc = new BMap.Geocoder();    

	map.addEventListener("click", function(e){        
		var pt = e.point;
		geoc.getLocation(pt, function(rs){
			var addComp = rs.addressComponents;
			map = rs.point;
			$(".xx").val(map.lat);
			$(".yy").val(map.lng);
			addre = addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber;
			$(".addre").val(addre);
		});        
	});
})
</script>