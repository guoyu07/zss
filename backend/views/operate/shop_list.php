<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '财务列表';
?>

<?= Html::jsFile('assets/order/laydate/laydate.js')?>
<style>
label{display:none}
#searchdiv{
    display:none;
    height:40px;
	padding:10px;
    //background-color: #efefef;
    border-bottom:2px solid #efefef;
}
#small{
    cursor:pointer;
    height:20px;
    background-color:#efefef;
    text-align:center;
}
.box{padding:20px; background-color:#fff; margin:50px 100px; border-radius:5px;}
.box a{padding-right:15px;}
#about_hide{display:none}
.layer_text{background-color:#fff; padding:20px;}
.layer_text p{margin-bottom: 10px; text-indent: 2em; line-height: 23px;}
.button{display:inline-block; *display:inline; *zoom:1; line-height:30px; padding:0 20px; background-color:#56B4DC; color:#fff; font-size:14px; border-radius:3px; cursor:pointer; font-weight:normal;}
.photos-demo img{width:200px;}
#testButton { color:rgb(0, 0, 0);cursor:pointer;font-size:13px;padding-top:6px;padding-bottom:6px;padding-left:15px;padding-right:15px;border-width:2px;border-color:rgb(170, 170, 170);border-style:double;border-radius:5px;background-color:rgb(242, 242, 242);}#testButton:hover{color:#000000;background-color:#aaaaaa;border-color:#aaaaaa;}
#search{ float:right; margin-right:15px;}
#search input{ float:left; width:220px; height:30px;}
#search button{ float:left; width:45px; height:30px;}
#time button{ float:left; margin:0 5px;}
#time input{ float:left; width:110px; height:30px;font-size:16px;}
.btn-group{margin-right:15px;}
</style>

<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>财务列表</h5>
          </div>
          <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
          <div id="searchdiv">
        	<!--time start -->
              <div id="time">
        		<button class="btn btn-inverse">时间范围</button>
        		<input type="text" class="laydate" id="start_time"/>
        		<input type="text" class="laydate" id="end_time"/>
            <input type="hidden" id="data" value="" />
        	</div>
        	<!--time end -->
        	<!-- start -->
        	<button class="btn btn-primary" style="margin-left:15px;">数据更新</button>
        	<!--- end --->
          <!-- start -->
          <button class="btn btn-info">Excel导出</button>
          <!-- end -->
        	 <!--start-top-serch-->
        	<div id="search">
        		<input type="text" placeholder="搜索门店..." id="word" />
        		<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        	</div>
        	<!--close-top-serch-->
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <div style="display:none;" id="excel"><?= json_encode($stat_shop) ?></div>
              <div style="display:none;" id="line"><?= Html::encode($shop_info) ?></div>
            	<div style="display:none;" id="date"><?= Html::encode($time) ?></div>
              <thead>
                <tr>
                  <th class="sort">ID&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">门店&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">门店地址&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">门店电话&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">销售额&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">赠品支出&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">营业额&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">统计时间&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                  <th class="sort">操作&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
                </tr>
              </thead>
              <tbody id="list">
                <?php foreach($stat_shop as $key => $model) : ?>
                <tr class="gradeX">
                  <td class="center"><?= $key+1 ?></td>
                  <td class="center">
                    <a href="<?php echo \Yii::$app->urlManager->createUrl(['operate/shop-detail']) ?>&shop_name=<?= $model['shop_name'] ?>&date=<?= $model['created_at'] ?>">
                    <?= Html::encode($model['shop_name']) ?>
                    </a>
                  </td>
                  <td class="center"><?= Html::encode($model['shop_address']) ?></td>
                  <td class="center"><?= Html::encode($model['shop_tel']) ?></td>
                  <td class="center">￥<?= Html::encode($model['shop_sale']) ?></td>
                  <td class="center">￥<?= Html::encode($model['shop_expend']) ?></td>
                  <td class="center">￥<?= Html::encode($model['shop_turnover']) ?></td>
                  <td class="center"><?= Html::encode($model['created_at']) ?></td>
                  <td class="center">
                    <a href="<?php echo \Yii::$app->urlManager->createUrl(['operate/shop-detail']) ?>&shop_name=<?= $model['shop_name'] ?>&date=<?= $model['created_at'] ?>">
                    <img id="see" width="20" height="20" title="门店信息查看" src="./assets/order/search.png" style="cursor:pointer;" alt="门店信息查看">
                    </a>
                  </td>
                </tr>
                <?php endforeach ; ?>
              </tbody>
            </table>
          </div>
        </div>



<?= Html::jsFile("./assets/order/layer.js") ?>
<?= Html::jsFile("./assets/highcharts/highcharts.js") ?>
<?= Html::jsFile("./assets/highcharts/modules/exporting.js") ?>
<script>

$(document).ready(function(){
  //排序图片
  $(".sort").toggle(
    function () {
      $(this).children().children().eq(0).attr("class","icon-caret-down");
    },
    function () {
      $(this).children().children().eq(0).attr("class","icon-caret-up");
    }
  );
  //日期插件
  $(".laydate").click(function(){
    laydate({
     elem: '#' + $(this).attr('id')
    })
  })
    //收起展开
    $("#small").toggle(function(){
      $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
      $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
    },function(){
      $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
      $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
     });
	 //搜索
	 $(".tip-bottom").click(function(){
     var start_time = $("#start_time").val();
     var end_time = $("#end_time").val();
     var word = $("#word").val();
     if(word.length >= 30){
       return layer.msg("门店名称输入过长！");
     }
     if(end_time > "<?= $date ?>" || start_time > end_time){
       return layer.msg("请输入正确时间范围！");
     }
     $.ajax({
         type : "POST",
         url : "<?php echo Yii::$app->urlManager->createUrl(['operate/shop-search']); ?>",
         data : {start_time:start_time,end_time:end_time,word:word,_csrf:"<?php echo Yii::$app->request->getCsrfToken();?>"},
         success : function(result){
          $(".nopadding").html(result);
          line_chart();
        }
      })
   })
   //数据更新
	 $(".btn-primary").click(function(){
     var start_time = $("#start_time").val();
     var end_time = $("#end_time").val();
     if(start_time == '' || end_time == ''){
       return layer.msg("请输入起始时间和结束时间后进行更新！");
     }
     if(start_time <= '2016-01-01' || end_time > "<?= $date ?>" || start_time > end_time){
       return layer.msg("请输入正确时间范围！");
     }
      $.ajax({
          type : "POST",
          url : "<?php echo Yii::$app->urlManager->createUrl(['operate/shop-creat']); ?>",
          data : {start_time:start_time,end_time:end_time,_csrf:"<?php echo Yii::$app->request->getCsrfToken();?>"},
          success : function(result){
           $(".nopadding").html(result);
           line_chart();
         }
       })
   })
   //excel导出
	 $(".btn-info").click(function(){
     //var csrfToken = $('meta[name="csrf-token"]').attr("content");
     var excel = $("#excel").html();
     //创建表单
     var temp = document.createElement("form");
      temp.action = "<?php echo Yii::$app->urlManager->createUrl(['operate/excel-shop']); ?>";
      temp.method = "post";
      temp.style.display = "none";
      //创建表单元素
      var opt = document.createElement("input");
      opt.type = "text";
      opt.name = "excel";
      opt.value = excel;
      temp.appendChild(opt);
      var hid = document.createElement("input");
      opt.type = "hidden";
      hid.name = "_csrf";
      hid.value = "<?php echo Yii::$app->request->getCsrfToken();?>";
      temp.appendChild(hid);
      document.body.appendChild(temp);
      temp.submit();
      return temp;
   })
    //门店折线统计图
    line_chart();
    function line_chart(){
      $('#shop_line').highcharts({
         title: {
             text: '门店收入折线统计图',
             x: -20 //center
         },
         subtitle: {
             text: '来源: 宅食送后台管理系统',
             x: -20
         },
         xAxis: {
             categories: JSON.parse($("#date").text())
         },
         yAxis: {
             title: {
                 text: 'RMB (￥)'
             },
             plotLines: [{
                 value: 0,
                 width: 1,
                 color: '#808080'
             }]
         },
         tooltip: {
             valueSuffix: '￥'
         },
         legend: {
             layout: 'vertical',
             align: 'right',
             verticalAlign: 'middle',
             borderWidth: 0
         },
         series: JSON.parse($("#line").text())
      });
    }
  });

</script>
<div id="shop_line" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
