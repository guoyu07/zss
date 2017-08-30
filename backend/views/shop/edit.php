<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = '门店修改';
?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<!--百度地图产品密钥-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=qsBc7zj8VnjrxUauu2xgwGeX"></script>

<style type="text/css">
.help-block{ float:left; width:150px; color:red;}
input{ float:left; margin-right: 10px;}
#allmap {width:800px; height:400px;}
</style>
 <div class="widget-box">
<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
  <h5>门店修改</h5>
</div>
<div class="widget-content nopadding">

 <?php $form = ActiveForm::begin(['id'=>'login-form',
	'options' => ['class' => 'form-horizontal','display' => 'none','name' => 'form',],
 ]);?>
<input type="hidden" name="ShopeditForm[id]" value="<?= $id; ?>" id='id'>

	<div class="control-group">
	<label class='control-label'>门店名称</label>
	  <div class='controls'>
		<?= $form->field($model, 'shop_name',['inputOptions'=>['value'=>$result['shop_name'],"class"=>"shop_name"]])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"90"]) ?>
	  </div>
	  	<span class="error" style="color:red;"></span>
	</div>
	<div class="control-group"> 
	  <label class="control-label">营业状态</label>
	  <div class="controls">
		<?php if($result['shop_status']==1): ?>
			<label><input type="radio" name="ShopeditForm[shop_status]" value='1' checked/>营业</label>
			<label> <input type="radio" name="ShopeditForm[shop_status]" value='0'/>关闭</label>
		<?php else: ?>
			<label><input type="radio" name="ShopeditForm[shop_status]" value='1' />营业</label>
			<label> <input type="radio" name="ShopeditForm[shop_status]" value='0' checked/>关闭</label>
		<?php endif; ?>	
	  </div>
	</div>
	
	<div class="control-group">
	<label class='control-label'>店长管理</label>
	  <div class='controls'>
	 		<?php foreach($admin as $val): ?>
				<?php if(in_array($val['id'],$result['shop_admin'])): ?>
					<input type="checkbox" name="ShopeditForm[admin][]" value="<?= Html::encode($val['id']); ?>" checked>
				<?php else: ?>
					<input type="checkbox" name="ShopeditForm[admin][]" value="<?= Html::encode($val['id']); ?>">
				<?php endif; ?>
				<?= Html::encode($val['username']); ?>&nbsp;&nbsp;
			<?php endforeach; ?>
	  </div>
	</div>

	<div class="control-group">
	<label class='control-label'>门店电话</label>
	  <div class='controls'>
	 		<?= $form->field($model, 'shop_tel',['inputOptions'=>['value'=>$result['shop_tel']]])->label(false)->textInput(["style"=>" width:300px; height:35px;"]) ?>	
	  </div>
	</div>
	
	<div class="control-group">
	 <label class='control-label'>门店地址</label>
	  <div class='controls'>
	  <?= $form->field($model, 'shop_address',['inputOptions'=>['value'=>$result['shop_address'],"class"=>"addre"]])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"250"]) ?>	
	  </div>
	</div>

	<div class="control-group">
	<label class='control-label'>门店经度</label>
	  <div class='controls'>
	  <?= $form->field($model, 'shop_x',['inputOptions'=>['value'=>$result['shop_x'],"class"=>"xx"]])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"8"]) ?>	
	  </div>
	</div>

	<div class="control-group">
	<label class='control-label'>门店纬度</label>
	  <div class='controls'>
	<?= $form->field($model, 'shop_y',['inputOptions'=>['value'=>$result['shop_y'],"class"=>"yy"]])->label(false)->textInput(["style"=>" width:300px; height:35px;","maxlength"=>"8"]) ?>	
	  </div>
	</div>
	
	<div class="control-group">
<label class='control-label'>地点点击选取</label>
  <div class='controls'>
		<div id="allmap"></div>
		<p>点击地图展示详细地址</p>
  </div>
</div>

	<div class="form-actions" style=" width:460px; text-align:center; ">
	  <button type="submit" class="btn btn-success">&nbsp;修&nbsp;改&nbsp;门&nbsp;店&nbsp;</button>
	</div>

<?php ActiveForm::end() ?>


</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	x = $(".xx").val();
	y = $(".yy").val();
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	var point = new BMap.Point(y,x);
	var marker = new BMap.Marker(point);  // 创建标注
	map.addOverlay(marker);              // 将标注添加到地图中
	map.centerAndZoom(point,18);
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
	//信息框提示
	var opts = {
	  width : 200,     // 信息窗口宽度
	  height: 100,     // 信息窗口高度
	  title : "<?= Html::encode($result['shop_name']); ?>" , // 信息窗口标题
	  enableMessage:true,//设置允许信息窗发送短息
	  message:"戳下面的链接看下地址喔~"
	}
	var infoWindow = new BMap.InfoWindow("地址：<?= Html::encode($result['shop_address']); ?>", opts);  // 创建信息窗口对象 
	marker.addEventListener("click", function(){          
		map.openInfoWindow(infoWindow,point); //开启信息窗口
	});

})

function check(id,shop_name){
	flag = 1;
	$.ajax({
	   type: "GET",
	   url: "<?= Yii::$app->urlManager->createUrl(['shop/check']); ?>",
	   data: "id="+id+"&shop_name="+shop_name,
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
	  var id = $("#id").val();
	  var shop_name = $(".shop_name").val();
	 msg =  check(id,shop_name);
	 if(msg){
			$(".error").html("");
		   return true;
	 }else{ 
		 $(".error").html("<font color=red>该店面已经存在</font>");
		  return false;
	 }
} );

</script>