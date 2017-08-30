<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = '门店添加';
?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<!--百度地图产品密钥-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=qsBc7zj8VnjrxUauu2xgwGeX"></script>

<style type="text/css">
.help-block{float:left; width:150px; color:red;}
input{float:left; margin-right: 10px;}
#allmap {width:800px; height:400px;}
</style>
 <div class="widget-box">
<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
  <h5>门店添加</h5>
</div>
<div class="widget-content nopadding">


<!--
<form action="" method='post' 'id'='login-form' class='form-horizontal'>
-->
 <?php $form = ActiveForm::begin(['id'=>'login-form',
	'options' => ['class' => 'form-horizontal','display' => 'none'],
 ]);?>


	<div class="control-group">
	<label class='control-label'>门店名称</label>
	  <div class='controls'>
		<?= $form->field($model, 'shop_name',['inputOptions'=>['placeholder'=>'请输入门店名称']])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"90"]) ?>	
	  </div>
	</div>
	<div class="control-group"> 
	  <label class="control-label">营业状态</label>
	  <div class="controls">
		<label><input type="radio" name="ShopForm[shop_status]" value='1' checked/>营业</label>
		<label> <input type="radio" name="ShopForm[shop_status]" value='0'/>关闭</label>
	  </div>
	</div>
	<div class="control-group"> 
	  <label class="control-label">请选择店长</label>
	  <div class="controls" style="width:500px;">
			<?php foreach($admin as $val): ?>
				<span style="110px;"><input type="checkbox" name="ShopForm[admin][]" value="<?= Html::encode($val['id']); ?>">
				<?= Html::encode($val['username']); ?>&nbsp;&nbsp;</span>
			<?php endforeach;  ?>
	  </div>
	</div>
	<div class="control-group">
	<label class='control-label'>门店电话</label>
	  <div class='controls'>
	 		<?= $form->field($model, 'shop_tel',['inputOptions'=>['placeholder'=>'请输入门店电话']])->label(false)->textInput(["style"=>" width:300px; height:35px;"]) ?>	
	  </div>
	</div>
	
	<div class="control-group">
	 <label class='control-label'>门店地址</label>
	  <div class='controls'>
	  <?= $form->field($model, 'shop_address',['inputOptions'=>['placeholder'=>'请输入门店地址',"class"=>"addre"]])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"250"]) ?>	
	  </div>
	</div>

	<div class="control-group">
	 <label class='control-label'>配送费用</label>
	  <div class='controls'>
	  <?= $form->field($model, 'distribution',['inputOptions'=>['placeholder'=>'请输入门配送费用']])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"250"]) ?>	
	  </div>
	</div>

	<div class="control-group">
	 <label class='control-label'>餐盒费用</label>
	  <div class='controls'>
	  <?= $form->field($model, 'lunchbox',['inputOptions'=>['placeholder'=>'请输入门餐盒费用']])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"250"]) ?>	
	  </div>
	</div>

	<div class="control-group">
	 <label class='control-label'>满增</label>
	  <div class='controls'>
		<select name="ShopForm[add_id]" style="width:300px;" class="add">
			<?php foreach($zj['add'] as $val): ?>
				<option value="<?= $val['add_id'] ?>"><?= $val['add_price'] ?></option>
			<?php endforeach; ?>
		</select>
		<span class="addinfo"></span>
	  </div>
	</div>

	<div class="control-group">
	 <label class='control-label'>满减</label>
	  <div class='controls'>
		<select name="ShopForm[subtract_id]" style="width:300px;" class="subtract">
			<?php foreach($zj['subtract'] as $val): ?>
				<option value="<?= $val['subtract_id'] ?>"><?= $val['subtract_price'] ?></option>
			<?php endforeach; ?>
		</select>
		<span class="subtractinfo"></span>
	  </div>
	</div>

	<div class="control-group">
	<label class='control-label'>门店经度</label>
	  <div class='controls'>
	  <?= $form->field($model, 'shop_x',['inputOptions'=>['placeholder'=>'请输入门店经度',"class"=>"xx"]])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"8"]) ?>	
	  </div>
	</div>

	<div class="control-group">
	<label class='control-label'>门店纬度</label>
	  <div class='controls'>
	<?= $form->field($model, 'shop_y',['inputOptions'=>['placeholder'=>'请输入门店纬度',"class"=>"yy"]])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"8"]) ?>	
	  </div>
	</div>

<div class="control-group">
<label class='control-label'>地点点击选取</label>
  <div class='controls'>
		<div id="allmap"></div>
		<p>点击地图展示详细地址</p>
  </div>
</div>
	
	<div class="form-actions" style=" width:430px; text-align:center; ">
	  <button type="submit" class="btn btn-success">&nbsp;添&nbsp;加&nbsp;</button>
	</div>

<?php ActiveForm::end() ?>


</div>
</div>

<script type="text/javascript">
// 百度地图API功能
/*var map = new BMap.Map("allmap");
map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
var point = new BMap.Point(116.331398,39.897445);
map.centerAndZoom(point,12);
var geoc = new BMap.Geocoder();    */

/*更加用户ip进行定位 start */
var map = new BMap.Map("allmap");
map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	var point = new BMap.Point();
	map.centerAndZoom(point,12);
	// 创建地址解析器实例
	var geoc = new BMap.Geocoder();
	// 将地址解析结果显示在地图上,并调整地图视野
	geoc.getPoint("北京市海淀区上地10街", function(point){
		if (point) {
			map.centerAndZoom(point, 24);
			map.addOverlay(new BMap.Marker(point));
		}else{
			alert("您选择地址没有解析到结果!");
		}
	}, "北京市");
/*更加用户ip进行定位 end */

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

$(document).on("change",".add",function(){
	var id = $(this).val();
	$.ajax({
		   type: "GET",
		   url: "<?=  Url::to(['shop/select-gift']); ?>",
		   data: "id="+id+"&type=1",
		   success: function(msg){
				if(msg.code==200){
					$(".addinfo").html("礼品是"+msg.data);
				}else{
				}
		   }
	});
});

$(document).on("change",".subtract",function(){
	var id = $(this).val();
	$.ajax({
		   type: "GET",
		   url: "<?=  Url::to(['shop/select-gift']); ?>",
		   data: "id="+id+"&type=0",
		   success: function(msg){
				if(msg.code==200){
					$(".subtractinfo").html("满减金额为"+msg.data);
				}else{
				}
		   }
	});
});
</script>