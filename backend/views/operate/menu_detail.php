<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '菜品详情';
?>
<style type="text/css">

.control-label{ font-size:16px; font-family: 微软雅黑}
#left{ float:left; border:0px red solid; width:40%; }
#right{  float:left; border:0px red solid;  }
.btn-primary{ width:110px;}
.status{cursor:pointer;}
#allmap {width:100%; height:40%;}
</style>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />


<div class="widget-box">
      <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
        <h5>门店管理</h5>
      </div>

      <div class="widget-content nopadding" >
        <form action="#" method="get" class="form-horizontal">

<!--left start -->
<div id="left">

<div class="control-group" style="">
  <label class="control-label"><button class="btn btn-primary" disabled>菜单名称</button></label>
  <div class="controls" style=" padding-top:20px;">
   <?= Html::encode($menu_info['menu_name']); ?>
  </div>
</div>
  <div class="control-group">
    <label class="control-label"><button class="btn btn-primary" disabled>菜单ID</button></label>
    <div class="controls"  style=" padding-top:15px;">
      <?= Html::encode($menu_info['menu_id']); ?>
    </div>
  </div>
 <div class="control-group">
  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>菜品单位</button></label>
  <div class="controls"  style=" padding-top:20px;">
  <?= Html::encode($menu_info['menu_code']); ?>
  </div>
</div>
 <div class="control-group">
  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>菜品单价</button></label>
  <div class="controls"  style=" padding-top:20px;">
  <?= Html::encode($menu_info['menu_price']); ?>
  </div>
</div>

</div>


<!--left end -->
<!--right start -->
<div id="right">

<div class="control-group">
  <label class="control-label"><button class="btn btn-primary" disabled>菜品分类</button></label>
  <div class="controls"  style=" padding-top:20px;">
  <?= Html::encode($menu_info['series_name']); ?>
  </div>
</div>

 <div class="control-group">

</div>
  <image src="add/menu/<?= Html::encode($menu_info['image']); ?>" width="150" height="40" style="margin-left:71px;margin-bottom:15px;"/>
</div>
<!--right end -->

<!--footer start -->
<div style="clear:both">
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
 //饼图1
 $('#menu_pie_1').highcharts({
     chart: {
         plotBackgroundColor: null,
         plotBorderWidth: null,
         plotShadow: false,
         type: 'pie'
     },
     title: {
         text: '<?= $date ?>该菜品各门店营业额分析饼图'
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
   //饼图2
   $('#menu_pie_2').highcharts({
       chart: {
           plotBackgroundColor: null,
           plotBorderWidth: null,
           plotShadow: false,
           type: 'pie'
       },
       title: {
           text: '<?= $date ?>该菜品配送类型营业额分析饼图'
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
           data: <?= $pie_menu_type_chart ?>
       }]
     });
})
</script>
<div class="" style="clear:both">
  <div id="menu_pie_1" style="width: 565px; height: 400px; float:left;"></div>
  <div id="menu_pie_2" style="width: 564px; height: 400px; float:left;"></div>
</div>
