 <?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '门店列表'; 
?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<!--百度地图产品密钥-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=qsBc7zj8VnjrxUauu2xgwGeX"></script>
<style type="text/css">
body{ font-size:15px; background-color:#f9f9f9;}
.control-label{ font-size:16px; font-family: 微软雅黑}
#left{ float:left; border:0px red solid; width:40%; }
#right{  float:left; border:0px red solid;  }
.btn-primary{ width:110px;}
.status{cursor:pointer;}
#allmap {width:100%; height:40%;}
.map{ margin-left:70px;}
</style>
  <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>门店管理</h5>
        </div>

        <div class="widget-content nopadding" >
          <form action="#" method="get" class="form-horizontal">

		  <div class="control-group">
              <label class="control-label">
					<button style="width:300px; margin-left:50px;" class="btn btn-primary" disabled>
					门店&nbsp;ID:&nbsp;
					<span id="shop_id"><?= Html::encode($shop['shop_id']); ?></span>
					<?php if(isset($shop['admin'])): ?>
						<span>&nbsp;&nbsp;&nbsp;店长姓名&nbsp;:&nbsp;
							<?php foreach($shop['admin'] as $val): ?>
								<?= Html::encode($val['username']) ?>&nbsp;
							<?php endforeach; ?>
						</span>
					<?php endif; ?>
					</button>
			 </label>
              <div class="controls" style="font-size:20px; padding-top:15px;">
              </div>
            </div>
			
<!--left start -->
<div id="left">

	<div class="control-group" style="">
	  <label class="control-label"><button class="btn btn-primary" disabled>门店名称</button></label>
	  <div class="controls" style=" padding-top:20px;">
	   <?= Html::encode($shop['shop_name']); ?>
	  </div>
	</div>
	  <div class="control-group">
		  <label class="control-label"><button class="btn btn-primary" disabled>营业状态</button></label>
		  <div class="controls"  style=" padding-top:15px;">
			<?php if(Html::encode($shop['shop_status'])==1): ?>
				<img value="1" src="./assets/ico/png/34.png" disabled>&nbsp;<span class="word">营业</span>
			<?php else: ?>
				<img value="0"  src="./assets/ico/png/40.png" disabled>&nbsp;<span class="word">关闭</span>
			<?php endif; ?>
		  </div>
		</div>
	 <div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>外卖开始时间</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= Html::encode(date("Y-m-d H:i:s",$shop['takeaway_start_time'])); ?>
	  </div>
	</div>
	 <div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>外卖结束时间</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= Html::encode(date("Y-m-d H:i:s",$shop['takeaway_end_time'])); ?>
	  </div>
	</div>
	 <div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>堂食开始时间</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= Html::encode(date("Y-m-d H:i:s",$shop['eat_end_time'])); ?>
	  </div>
	</div>
	 <div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>堂食结束时间</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= Html::encode(date("Y-m-d H:i:s",$shop['eat_end_time'])); ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>门店经度</button></label>
	  <div class="controls xx"  style=" padding-top:20px;">
		<?= Html::encode($shop['shop_x']); ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >门店纬度</button></label>
	  <div class="controls yy"  style=" padding-top:20px;">
		<?= Html::encode($shop['shop_y']); ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >满增</button></label>
	  <div class="controls yy"  style=" padding-top:20px;">
		<?php if($shop['add_price']): ?>
			满<?= Html::encode($shop['add_price']); ?>赠送<?= Html::encode($shop['gift_name']); ?>
		<?php endif; ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >满减</button></label>
	  <div class="controls yy"  style=" padding-top:20px;">
		<?php if($shop['subtract_price']): ?>
			满<?= Html::encode($shop['subtract_price']); ?>减<?= Html::encode($shop['subtract_subtract']); ?>
		<?php endif; ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >配送费用</button></label>
	  <div class="controls yy"  style=" padding-top:20px;">
		<?= Html::encode($shop['distribution']); ?>
	  </div>
	</div>
	<div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled >餐盒费用</button></label>
	  <div class="controls yy"  style=" padding-top:20px;">
		<?= Html::encode($shop['lunchbox']); ?>
	  </div>
	</div>

</div>


<!--left end -->
<!--right start -->
<div id="right">

  <div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>门店地址</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= Html::encode($shop['shop_address']); ?>
	  </div>
	</div>
	 <div class="control-group">
		  <label class="control-label"><button class="btn btn-primary" disabled>门店电话</button></label>
		  <div class="controls"  style=" padding-top:20px;">
			<?= Html::encode($shop['shop_tel']); ?>
		  </div>
		</div>
	<div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>门店类型</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?php foreach($type as $k=>$v): ?>
			<?php if(in_array($v['type_id'],$shop['shop_type'])): ?>
				<input type="checkbox" name="" value="<?= Html::encode($v['type_id']); ?>" checked disabled>
			<?php else: ?>
				<input type="checkbox" name="" value="<?= Html::encode($v['type_id']); ?>" disabled>
			<?php endif; ?>
			<?= Html::encode($v['type_name']); ?>&nbsp;&nbsp;
		<?php endforeach; ?>
	  </div>
	</div>
	
	 <div class="control-group map">
	 <br>
			<div id="allmap"></div>
			<p>点击地图展示详细地址</p>
	</div>

</div>
<!--right end -->
 
<!--footer start -->
<div style="clear:both">
 	<div class="control-group">
		  <label class="control-label"><button class="btn btn-primary" disabled>备注(通知)</button></label>
		  <div class="controls"  style=" padding-top:20px;">
			<div style="border:1; width:80%; height:100px;"><?= htmlspecialchars($shop['shop_remark']); ?></div>
		  </div>
		</div>

		
</div>
<!-- footer end -->

	  </form>
	</div>
</div>

<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
<script type="text/javascript">
$(document).ready(function(){
	x = $(".xx").text();
	y = $(".yy").text();
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	var point = new BMap.Point(y,x);
	var marker = new BMap.Marker(point);  // 创建标注
	map.addOverlay(marker);              // 将标注添加到地图中
	map.centerAndZoom(point,15);
	var geoc = new BMap.Geocoder();    

	map.addEventListener("click", function(e){        
		var pt = e.point;
		geoc.getLocation(pt, function(rs){
			var addComp = rs.addressComponents;
			map = rs.point;
		});        
	});
	//信息框提示
	var opts = {
	  width : 200,     // 信息窗口宽度
	  height: 100,     // 信息窗口高度
	  title : "<?= Html::encode($shop['shop_name']); ?>" , // 信息窗口标题
	  enableMessage:true,//设置允许信息窗发送短息
	  message:"戳下面的链接看下地址喔~"
	}
	var infoWindow = new BMap.InfoWindow("地址：<?= Html::encode($shop['shop_address']); ?>", opts);  // 创建信息窗口对象 
	marker.addEventListener("click", function(){          
		map.openInfoWindow(infoWindow,point); //开启信息窗口
	});

})

	$(document).on("click",".status",function(){
			status = $(this).attr("value");
			shop_id = $("#shop_id").text();
			csrf = $("#_csrf").val();
			$.ajax({
			   type: "POST",
			   url: "<?= Yii::$app->urlManager->createUrl(['shop/shop-status']); ?>",
			   data: "status="+status+"&shop_id="+shop_id+"&_csrf="+csrf,
			   success: function(msg){
					if(msg['code']==200 && status==1){
						$(".status").attr("value",0);
						$(".status").attr("src","./assets/ico/png/40.png");
						$(".word").html("关闭");
						//alert("门店关闭成功");
					}else if(msg['code']==200 && status==0){
						$(".status").attr("value",1);
						$(".status").attr("src","./assets/ico/png/34.png");
						$(".word").html("营业");
						//alert("门店开启成功");
					}else{
						alert("门店状态修改失败");
					}
			   }
			});

	});



</script>
