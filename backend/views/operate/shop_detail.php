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

.control-label{ font-size:16px; font-family: 微软雅黑}
#left{ float:left; border:0px red solid; width:40%; }
#right{  float:left; border:0px red solid;  }
.btn-primary{ width:110px;}
.status{cursor:pointer;}
#allmap {width:100%; height:40%;}
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
					<span>&nbsp;&nbsp;&nbsp;店长姓名&nbsp;:&nbsp;
             <?php
               foreach($shop['admin'] as $v) {
                 echo $v."&nbsp;";
               }
             ?>
          </span>
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
				<img class="status" value="1" src="./assets/ico/png/34.png">&nbsp;<span class="word">营业</span>
			<?php else: ?>
				<img class="status" value="0"  src="./assets/ico/png/40.png">&nbsp;<span class="word">关闭</span>
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
		<?php foreach($types as $k=>$v): ?>
			<?php if(in_array($v['type_id'],$shop['type'])): ?>
				<input type="checkbox" name="" value="<?= Html::encode($v['type_id']); ?>" checked disabled>
			<?php else: ?>
				<input type="checkbox" name="" value="<?= Html::encode($v['type_id']); ?>" disabled>
			<?php endif; ?>
			<?= Html::encode($v['type_name']); ?>&nbsp;&nbsp;
		<?php endforeach; ?>
	  </div>
	</div>

	 <div class="control-group">
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
			<div><?= htmlspecialchars($shop['shop_remark']); ?></div>
		  </div>
		</div>


</div>
<!-- footer end -->

	  </form>
	</div>
</div>

<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

<?= Html::jsFile("./assets/order/layer.js") ?>
<?= Html::jsFile("./assets/highcharts/highcharts.js") ?>
<?= Html::jsFile("./assets/highcharts/modules/exporting.js") ?>

<script type="text/javascript">
$(document).ready(function(){
	x = $(".xx").text();
	y = $(".yy").text();
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
		});
	});
  //饼图1
  $('#shop_pie_1').highcharts({
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: '<?= $date ?>本店各分类营业额分析饼图'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                  style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                  }
              }
          }
      },
      series: [{
          name: 'Brands',
          colorByPoint: true,
          data: <?= $pie_series_chart ?>
      }]
    });
    //饼图2
    $('#shop_pie_2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<?= $date ?>本店各菜品营业额分析饼图'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: <?= $pie_menu_chart ?>
        }]
      });
})
</script>

<div id="shop_pie_1" style="width: 565px; height: 400px; float:left;"></div>
<div id="shop_pie_2" style="width: 564px; height: 400px; float:left;"></div>
