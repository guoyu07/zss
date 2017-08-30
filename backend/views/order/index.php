<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
$this->title = '订单管理';
?>
<?= Html::jsFile('./assets/order/laydate/laydate.js')?>
<?= Html::cssFile('./assets/order/lab.css')?>
<?= Html::cssFile('./assets/order/xia.css')?>
<?= Html::jsFile('./assets/order/layer.js')?> 

<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>门店列表</h5>
          </div>
<div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
    <div id="searchdiv">
		<!--time start -->
        <div id="time">
			<button class="btn btn-inverse">时间范围</button>
			<input type="text" id="start_time" class="date"/>
			<input type="text" id="end_time" class="date" />
		</div>
		<!--time end -->
		<!------>

		<dl class="select">
			<dt value='' id="pay_type">选择支付方式</dt>
			<dd>
				<ul>
					<li><a href="javascript:void(0)" value="online">微信支付</a></li>
					<li><a href="javascript:void(0)" value="balance" >会员支付</a></li>
				</ul>
			</dd>
		</dl>

		<dl class="select">
			<dt value="" id="pay_status">选择订单状态</dt>
			<dd>
				<ul>
					<li><a href="javascript:void(0)" value="0">未支付</a></li>
					<li><a href="javascript:void(0)" value="1" >已付款</a></li>
					<li><a href="javascript:void(0)" value="2">订单关闭</a></li>
					<li><a href="javascript:void(0)" value="3">成功</a></li>
				</ul>
			</dd>
		</dl>
	
		<dl class="select">
			<dt value="" id="delivery_type">选择派送类型</dt>
			<dd>
				<ul>
					<li><a href="javascript:void(0)" value="1">堂食</a></li>
					<li><a href="javascript:void(0)" value="2" >外卖</a></li>
					<li><a href="javascript:void(0)" value="3">自取</a></li>
				</ul>
			</dd>
		</dl>

		
		<!------>
		 <!--start-top-serch-->
		<div id="search">
			<input type="text" placeholder="搜索..." id="word"/>
			<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
		</div>
		<!--close-top-serch-->
    </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:12px;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>订单号码</th>
				  <th>收货人姓名</th>
				   <th>电话</th>
				   <th>派送类型</th>
                  <th>座位号</th>
                  <th>金额</th>			  
				  <th>订单状态</th>
				  <th>支付方式</th>
				  <th>取餐号</th>
				  <th>创建时间</th>
                  <th>修改时间</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($models as $model): ?>
                <tr class="gradeX">
                  <td><?= Html::encode($model['order_id']) ?></td>
                  <td><a href="javascript:void(0)"><?= Html::encode($model['order_sn']) ?></a></td>
				  <td><?= Html::encode($model['user_name']) ?></td>
				    <td><?= Html::encode($model['user_phone']) ?></td>
					<td>
						<?php if($model['delivery_type']==1){ echo "堂食"; }elseif($model['delivery_type']==2){ echo "自取"; }elseif($model['delivery_type']==3){ echo "外卖"; } ?>
					</td>
                  <td><?php if(Html::encode($model['seat_number'])){ echo Html::encode($model['seat_number']); }else{ echo "—"; } ?></td>
                   <td>￥<?= Html::encode($model['order_total']) ?></td> 				 
				   <td>
					<?php 
						if(Html::encode($model['order_status'])==0)
						{
							echo "未支付"; 
						}
						elseif(Html::encode($model['order_status'])==1)
						{ 
							echo "已付款"; 
						}elseif(Html::encode($model['order_status'])==2)
						{ 
							echo "订单关闭"; 
						}elseif(Html::encode($model['order_status'])==3)
						{ 
							echo "成功"; 
						} 
				   ?>
				   </td>
				   <td>
				   <?php if(Html::encode($model['payonoff'])=='online'){ echo "微信支付"; }elseif(Html::encode($model['payonoff'])=='balance'){ echo "会员支付"; } ?>
				   </td>

				   <td><?php if(Html::encode($model['meal_number'])){ echo Html::encode($model['meal_number']); }else{ echo "—"; } ?></td>
				   <td><?= Html::encode(date('Y-m-d H:i',$model['created_at'])) ?></td>
                    <td><?= Html::encode(date('Y-m-d H:i',$model['updated_at'])) ?></td>
					<td><img id="see" value="<?= Html::encode($model['order_id']) ?>" alt="查看" style="cursor:pointer;" src="./assets/order/search.png" title="查看" width=20 height=20 onclick="showdiv(<?= Html::encode($model['order_id']) ?>);"></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
<!---遮罩层 start -->
<div id="bg"></div>
<div id="show">	
		
</div>
<!----遮罩层 end --->
<img id="loading" src="./assets/order/load.gif" style="z-index:20000; background-color:rgba(0,152,50,0.7); display:none; z-index:999; position:fixed; top:55%; margin-top:-100px; left:45%">

<script>
//loading
function loading(num){
	if(num==1){
		$("#loading").show();
	}else{
		$("#loading").hide();
	}
}
//查询
$(".select").each(function(){
		var s=$(this);
		var z=parseInt(s.css("z-index"));
		var dt=$(this).children("dt");
		var dd=$(this).children("dd");
		var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   //展开效果
		var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    //关闭效果
		dt.click(function(){dd.is(":hidden")?_show():_hide();});
		dd.find("a").click(function(){ 
			id = $(this).attr("value");
			dt.attr("value",id);
			dt.html($(this).html());_hide();
			//查询 && 取得传值信息
			pay_type = $("#pay_type").attr("value");
			pay_status = $("#pay_status").attr("value");
			delivery_type = $("#delivery_type").attr("value");
			$.ajax({
		   type: "GET",
				   url: "<?= Yii::$app->urlManager->createUrl(['order/search-order']) ?>",
				   data: "pay_type="+pay_type+"&pay_status="+pay_status+"&delivery_type="+delivery_type,
				   beforeSend: function(){
						//$("#bg").show();
						//loading(1);
					},
					complete: function(){
						//$("#bg").hide();
						//loading(0);
					},
				   success: function(msg){
						if(msg.code == 200){
							$(".widget-content").html(msg.data);
						}else if(msg.code == 400){
							alert("查询失败");
						}
				   }
			});
		});     //选择效果（如需要传值，可自定义参数，在此处返回对应的“value”值 ）
		$("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
})


function showdiv(id) {
			$.ajax({
			   type: "GET",
			   url: "<?= Yii::$app->urlManager->createUrl(['order/see-order']) ?>",
			   data: "id="+id,
			    beforeSend: function(){
						//loading(1);
				},
				complete: function(){
					//loading(0);
				},
			   success: function(msg){
					if(msg == "0"){
						layer.msg('该订单下没有详细信息了');
					}else{
						//$("#show").html(msg);
						if(msg.code == 200){
							$("#show").html(msg.data);
							$("#bg").show();
							$("#show").show();
						}else if(msg.code == 400){
							alert("查询失败");
						}else if(msg.code == 403){
							alert("暂无权限");
						}
					}
			   }
			});           
}
function hidediv() {
           $("#bg").hide();
			$("#show").hide();
}
 
$(document).ready(function(){
    $("#small").toggle(function(){
            $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
          },function(){
            $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
     });

 //模糊查询搜索
 $(document).on("click",".tip-bottom",function(){
	 word = $("#word").val();
	 start_time = $("#start_time").attr("value");
	 end_time = $("#end_time").attr("value");
	 $.ajax({
			   type: "GET",
			   url: "<?= Yii::$app->urlManager->createUrl(['order/like-order']); ?>",
			   data: "word="+word+"&start_time="+start_time+"&end_time="+end_time,
			   success: function(msg){
					if(msg.code == 200){
							$(".widget-content").html(msg.data);
					}else if(msg.code == 400){
						alert("查询失败");
					}
			   }
		 });	
 });

	$(".date").click(function(){
		laydate({
			elem: '#' + $(this).attr('id')
		})
	})

});

  

</script>