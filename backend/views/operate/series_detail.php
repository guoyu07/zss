<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '分类详情';
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
        <h5>分类管理</h5>
      </div>

      <div class="widget-content nopadding" >
        <form action="#" method="get" class="form-horizontal">

<!--left start -->
<div id="left">

<div class="control-group" style="">
  <label class="control-label"><button class="btn btn-primary" disabled>分类名称</button></label>
  <div class="controls" style=" padding-top:20px;">
   <?= Html::encode($series_name); ?>
  </div>

</div>


<!--left end -->
<!--right start -->
<div id="right">

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
         text: '<?= $date ?>本分类各营业额分析饼图'
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
           text: '<?= $date ?>本分类各门店营业额'
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
           data: <?= $pie_shop_chart ?>
       }]
     });
})
</script>
<div class="" style="clear:both">
  <div id="menu_pie_1" style="width: 563px; height: 400px; float:left;"></div>
  <div id="menu_pie_2" style="width: 563px; height: 400px; float:left;"></div>
</div>
