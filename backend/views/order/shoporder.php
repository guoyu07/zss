<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
$this->title = '门店订单';
?>
<?= Html::jsFile('./assets/order/laydate/laydate.js')?>
<?= Html::cssFile('./assets/order/lab.css')?>
<?= Html::cssFile('./assets/order/xia.css')?>
<?= Html::jsFile('./assets/order/layer.js')?> 
<?= Html::jsFile('./assets/order/LodopFuncs.js')?> 
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
					<li><a href="javascript:void(0)" value="online">线上支付</a></li>
					<li><a href="javascript:void(0)" value="balance" >余额支付</a></li>
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
           
                <tr>
                  <th>ID</th>
                  <th>订单号码</th>
				  <th>收货人姓名</th>
				   <th>电话</th>
				   <th>派送类型</th>
                  <th>座位号</th>
                  <th>实付款</th>			  
				  <th>订单状态</th>
				  <th>支付方式</th>
				  <th>取餐号</th>
				  <th>创建时间</th>
                  <th>修改时间</th>
				  <th>操作</th>
				  <th>打印</th>
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
                   <td>￥<?= Html::encode($model['order_payment']) ?></td> 				 
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
				    <?php if(Html::encode($model['payonoff'])=='online'){ echo "线上支付"; }elseif(Html::encode($model['payonoff'])=='balance'){ echo "余额支付"; } ?>
				   </td>

				   <td><?php if(Html::encode($model['meal_number'])){ echo Html::encode($model['meal_number']); }else{ echo "—"; } ?></td>
				   <td><?= Html::encode(date('Y-m-d H:i',$model['created_at'])) ?></td>
                    <td><?= Html::encode(date('Y-m-d H:i',$model['updated_at'])) ?></td>
					<td>
						<img id="see" value="<?= Html::encode($model['order_id']) ?>" alt="查看" style="cursor:pointer;" src="./assets/order/search.png" title="查看" width=20 height=20 onclick="showdiv(<?= Html::encode($model['order_id']) ?>);">
					</td>
					<td class="printer_<?= $model['order_id'] ?>">
						<?php if($model['order_status']==0): ?>
							<?= "未支付" ?>
						<?php elseif($model['order_status']==1): ?>
							
							<img id="see" value="<?= Html::encode($model['order_id']) ?>" shop_id='<?= Html::encode($model['shop_id']) ?>'  alt="打印" style="cursor:pointer;" src="./assets/order/printer-blue.png" title="打印" width=20 height=20 class='dayin'>
						<?php elseif($model['order_status']==2): ?>
							<?= "已接单" ?>
						<?php elseif($model['order_status']==3): ?>
							<?= "订单完成" ?>
						<?php endif; ?>
					</td>
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


<!-- 音乐开始 -->
<audio src="./music/dream.mp3" controls="controls"   style="display:none;"  shop_id="<?= Html::encode($shop_id) ?>";></audio> 

<!-- 音乐结束 -->

<script>
// 定时刷新页面
function myrefresh(){
window.location.reload();
}
// setTimeout('myrefresh()',15000); 
</script>
<script>
// 访问页面检测未打印的订单，有订单就播放音乐
$(document).ready(function(){
	data.get_music();
});
var data = {
	get_music:function(){	
	var shop_id=$("audio").attr('shop_id');
		// alert(shop_id);
	$.ajax({
			type: "GET",
			url: "<?php echo Url::to(['order/get-order']);?>",
			dataType: 'json',
			data:{shop_id:shop_id},
			success: function(msg){
				if (msg.data != '')
				{
					data.musicstart();
				}
			}
		});
	},
	musicstart:function(){
		$("audio").attr('autoplay','autoplay');
		var music=setInterval(data.musicend,5000);
	},

	musicend:function(){
		$("audio").removeAttr('src');
	}
}
//打印小票
	$('.dayin').click(function(){
		var order_id = $(this).attr('value');
		var shop_id =$(this).attr('shop_id');
		var dayin=$(this);
		$.ajax({
			type: "GET",
			url: "<?= Yii::$app->urlManager->createUrl(['order/print-order']) ?>",
			data:{order_id:order_id,shop_id:shop_id},
			dataType: 'json',
			success: function(msg){
				msg = eval(msg);
			if (msg != '')
				{
					var _html='';
					var _html2=''
					//就餐类型
					var delivery_type='';
					//菜品
					var data='';
					if(msg.order.delivery_type==1){
						delivery_type='<span style="font-weight:bold;font-size:30px">堂食</span>';
					}else if(msg.order.delivery_type==2){
						delivery_type='<span style="font-weight:bold;font-size:30px">自取</span>';
					}else if(msg.order.delivery_type==3){
						delivery_type='<span style="font-weight:bold;font-size:30px">外卖</span>';
					};

					for (var i = 0; i<msg.info.length; i++) {
						data+='<tr><td>'+msg.info[i]['menu_name']+'</td><td style="text-align:center;">'+msg.info[i]['menu_num']+'</td><td style="text-align: right;">'+msg.info[i]['menu_price']+'</td></tr>';
					};	

					//外卖自提档口
					if(msg.order.delivery_type==3 || msg.order.delivery_type==2){

						_html+='<div id="form1" style="width:50%;">'
							+'<h6 style="width: 100%;text-align: center;border-bottom:1px solid black;font-size: 30px;">宅食送外卖单</h6>'
							+'<div>'+delivery_type+'&nbsp&nbsp取餐号：'+msg.order.meal_number+'</div>'
							+'<p style="color:#00F;border-bottom:1px solid black;width: 100%;">'
							+'<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="font-weight: bold;height: 30px;border-bottom:1px solid black;font-size:15px;" ><tr><td>菜品</td><td style="text-align:center;">数量</td><td style="text-align: right;">金额</td></tr>'
							+data
							+'<tr style="height:10px;" ><td></td></tr><tr><td>总价格:</td><td></td><td style="text-align: right;">￥'+msg.order.order_total+'</td></tr>'
							+'<tr ><td></td></tr><tr><td>实付款:</td><td></td><td style="text-align: right;">￥'+msg.order.order_payment+'</td></tr></table>'
							+'<p style="color:#00F;font-weight: bold;border-bottom:1px solid black;width: 100%;">'
							+'送货地址:'+msg.order.order_address+'<br />'
							+'收货人姓名:'+msg.order.user_name+'<br />'
							+'收货人电话:'+msg.order.user_phone+'<br /></p>'
							+'<p style="color:#00F;font-weight: bold;width: 100%;">'
							+'门店地址:'+msg.order.shop_address+'<br/>'
							+'门店电话: '+msg.order.shop_tel+'<br />'
							+'<img src="./assets/order/print.jpg" alt="" style=" width:150px; height:150px;margin-left:80px;"/>'
							+'</p></div><br />';

							prn1_print(_html);

					}else if(msg.order.delivery_type==1){

						_html+='<div id="form1" style="width:50%;">'
							+'<h6 style="width: 100%;text-align: center;border-bottom:1px solid black;font-size: 30px;">宅食送堂食出餐单</h6>'
							+'<div>'+delivery_type+'&nbsp&nbsp取餐号：'+msg.order.meal_number+'&nbsp&nbsp座位号'+msg.order.seat_number+'</div>'
							+'<p style="color:#00F;border-bottom:1px solid black;width: 100%;">'
							+'<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="font-weight: bold;height: 30px;border-bottom:1px solid black;font-size:15px;" ><tr><td>菜品</td><td>数量</td><td style="text-align: right;">金额</td></tr>'
							+data
							+'<tr style="height:10px;" ><td></td></tr><tr><td>总价格:</td><td></td><td style="text-align: right;">￥'+msg.order.order_total+'</td></tr>'
							+'<tr ><td></td></tr><tr><td>实付款:</td><td></td><td style="text-align: right;">￥'+msg.order.order_payment+'</td></tr></table>'
							+'</div><br />';
							prn1_print(_html);
					}
					

					//堂食物档口
					if(msg.order.delivery_type==1){

						_html2+='<div id="form1" style="width:50%;">'
						+'<h6 style="width: 100%;text-align: center;border-bottom:1px solid black;font-size: 25px;">宅食送堂食出餐单</h6>'
						+'<div>'+delivery_type+'&nbsp&nbsp取餐号：'+msg.order.meal_number+'&nbsp&nbsp座位号'+msg.order.seat_number+'</div>'
						+'<p style="color:#00F;border-bottom:1px solid black;width: 100%;">'
						+'<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="font-weight: bold;height: 30px;border-bottom:1px solid black;font-size:15px;" ><tr><td>菜品</td><td>数量</td><td style="text-align: right;">金额</td></tr>'
						+data
						+'<tr style="height:10px;" ><td></td></tr><tr><td>总价格:</td><td></td><td style="text-align: right;">￥'+msg.order.order_total+'</td></tr>'
						+'<tr ><td></td></tr><tr><td>实付款:</td><td></td><td style="text-align: right;">￥'+msg.order.order_payment+'</td></tr></table>'
						+'</div><br />';
						prn2_print(_html2);

					}else if(msg.order.delivery_type==3 || msg.order.delivery_type==2){

						_html2+='<div id="form1" style="width:50%;">'
							+'<h6 style="width: 100%;text-align: center;border-bottom:1px solid black;font-size: 25px;">宅食送外卖单</h6>'
							+'<div>'+delivery_type+'&nbsp&nbsp取餐号：'+msg.order.meal_number+'</div>'
							+'<p style="color:#00F;border-bottom:1px solid black;width: 100%;">'
							+'<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="font-weight: bold;height: 30px;border-bottom:1px solid black;font-size:15px;" ><tr><td>菜品</td><td style="text-align:center;">数量</td><td style="text-align: right;">金额</td></tr>'
							+data
							+'<tr style="height:10px;" ><td></td></tr><tr><td>总价格:</td><td></td><td style="text-align: right;">￥'+msg.order.order_total+'</td></tr>'
							+'<tr ><td></td></tr><tr><td>实付款:</td><td></td><td style="text-align: right;">￥'+msg.order.order_payment+'</td></tr></table>'
							+'<p style="color:#00F;font-weight: bold;border-bottom:1px solid black;width: 100%;">'
							+'送货地址:'+msg.order.order_address+'<br />'
							+'收货人姓名:'+msg.order.user_name+'<br />'
							+'收货人电话:'+msg.order.user_phone+'<br /></p>'
							+'<p style="color:#00F;font-weight: bold;width: 100%;">'
							+'门店地址:'+msg.order.shop_address+'<br/>'
							+'门店电话: '+msg.order.shop_tel+'<br />'
							+'<img src="./assets/order/print.jpg" alt="" style=" width:150px; height:150px; margin-left:80px;"/>'
							+'</p></div><br />';
							prn2_print(_html2);

					}
					

					for (var i = 0; i<msg.dangkou.length; i++) {
							var series='';
							series+='<div id="form1" style="width:40%;">'
							+'<h6 style="width: 100%;text-align: center;border-bottom:1px solid black;font-size: 25px;">宅食送</h6>'
							+'<div>'+delivery_type+'&nbsp&nbsp取餐号：'+msg.order.meal_number+'</div>'
							+'<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="font-weight: bold;height: 30px;border-bottom:1px solid black;font-size:15px;" ><tr><td>菜品</td><td>数量</tr>'
							+'<tr><td>'+msg.dangkou[i]['menu_name']+'</td><td style="text-align:center;">'+msg.dangkou[i]['menu_num']+'</td></tr>></table><br />'
							+'<div style="height:10px;margin-bottom:10px;">&请认真做好每一道菜</div>'
							+'</div>'
							// alert(series);
							prn3_print(series,msg.dangkou[i]['print_num']); 
							// 
					};

				}
				
				
				// prn1_preview(_html);
				// prn2_preview(_html2);
				dayin.replaceWith('已接单');		
				
			}
		});	
	})
</script>

<script type="text/javascript">

// 外卖自提打印小票1
    var LODOP; //声明为全局变量
    function prn1_print(_html){
        CreateOneFormPage(_html);
        if (LODOP.SET_PRINTER_INDEX(0)) 
        LODOP.PRINT();
    };

// 堂食打印小票2
    function prn2_print(_html2){
        CreateOneFormPage2(_html2);
        if (LODOP.SET_PRINTER_INDEX(1)) 
        LODOP.PRINT();
    };

    //档口打印小票
    function prn3_print(series,num){
        CreateOneFormPage2(series);
        if (LODOP.SET_PRINTER_INDEX(num)) 
        LODOP.PRINT();
    };

// 预览1
    // function prn1_preview(_html) {
    //     CreateOneFormPage(_html);
    //     if (LODOP.SET_PRINTER_INDEX(0)) 
    //     LODOP.PREVIEW();
    // };
// 预览2
    // function prn2_preview(_html2) {
    //     CreateOneFormPage(_html2);
    //     if (LODOP.SET_PRINTER_INDEX(0)) 
    //     LODOP.PREVIEW();
    // };



    function CreateOneFormPage(_html){
        LODOP=getLodop();  
        LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_表单一");
        LODOP.SET_PRINT_PAGESIZE(3, "79mm","2mm",""); 
        LODOP.SET_SHOW_MODE("NP_NO_RESULT",true);     
        LODOP.ADD_PRINT_HTM(10,10,600,600,_html);
    };

    function CreateOneFormPage2(_html){
        LODOP=getLodop();  
        LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_表单一");
        LODOP.SET_PRINT_PAGESIZE(3, "79mm","2mm",""); 
        LODOP.SET_SHOW_MODE("NP_NO_RESULT",true);     
        LODOP.ADD_PRINT_HTM(10,10,600,600,_html);
    };

</script>







<!--遮罩层 end -->
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
				   data: "pay_type="+pay_type+"&pay_status="+pay_status+"&delivery_type="+delivery_type+"&admin="+$("input[name=admin]").val(),
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


//订单详情
function showdiv(order_id) {
			$.ajax({
			   type: "GET",
			   url: "<?= Yii::$app->urlManager->createUrl(['order/see-order']) ?>",
			   data: "order_id="+order_id,
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
			   data: "admin="+$("input[name=admin]").val()+"&word="+word+"&start_time="+start_time+"&end_time="+end_time,
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
 });

	$(".date").click(function(){
		laydate({
			elem: '#' + $(this).attr('id')
		})
	})

});

  

</script>