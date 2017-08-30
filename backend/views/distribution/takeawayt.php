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
<style type="text/css">
*{padding: 0;margin: 0; list-style:none; }
body{
	background: white;
}
/*头部*/
#head{
width: 100%;
height: 50px;
margin: 0 auto;
margin-top: 20px;
}
.head_son{
width: 50%;
height: 50px;
float: left;
color: white;
text-align: center;
line-height: 50px;
cursor: pointer;
}
.son1{
background: #ea908b;
font-size: 35px;
}
.son2{
background: #80c269;
font-size: 35px;
}
/*底部*/
#foot{
width: 100%;
height: 100%;
margin: 0 auto;

position: relative;
}
.foot_son{
width: 100%;
height: 100px;
position: absolute;
left: 0px;top: 0px;
display: none;
}

#foot li{
height:40px;width: 100%;
background: white;
margin-top: 3px;
margin-bottom: 3px;
}
.over{
font-size: 25px;
}
 table tr td{ border-bottom:1px solid #e5e5e5;}
.ft1 table tr td a{ text-decoration:none; color:#fff; padding:5px 10px; background:#ea908b; border-radius:10px; box-shadow:0px 5px 5px #ee534b;}


</style>
</head>
<div id="head">
		<div class="head_son son1">未抢的单</div>
		<div class="head_son son2">已抢的单</div>
	</div>
	<div id="foot">
	<div class="foot_son ft1" style="display:block;">
    
		<table class="table table-striped" width="100%" style="text-align:center; border-spacing:0; border-collapse:collapse;">
			<thead style="color: white;font-size: 30px; line-height:50px;background: #ea908b;">
				<tr >
					<td width="14%">订单id</td>	
					<td width="14%">订单号</th>
					<td width="14%">客户名称</th>	
					<td width="14%">客户电话</td>
					<td width="14%">取餐号</td>
					<td width="14%">送货地址</td>
					<td width="16%">操作</td>
				</tr>
			</thead>
			<tbody style="font-size: 25px;line-height:70px;">
			<?php foreach($data as $key=>$value): ?>
				<tr class="tr" >
					<td><?= Html::encode($value['order_id']) ?></td>
					  <td><?= Html::encode($value['order_sn']) ?></td>
					  <td><?= Html::encode($value['site_name']) ?></td>
					  <td><?= Html::encode($value['meal_number']) ?></td>
					  <td><?= Html::encode($value['site_phone']) ?></td>
					  <td><?= Html::encode($value['site_detail']) ?></td>
					<td value="<?= Html::encode($value['order_id']) ?>"><a href="javascript:void(0)" class='qiang over btn btn-primary red start' style="border:none" orderid="1">抢单</a></td>
				</tr>
			<?php endforeach;  ?>		
			</tbody>
		</table>
	</div>

<div class="foot_son ft2">
	<div class="portlet-body form">
		<table class="table table-striped" width="100%" style="text-align:center; border-spacing:0; border-collapse:collapse；">
			<thead style="color: white;font-size: 30px; line-height:50px;background: #80c269;">
				<tr >
				  <td>订单ID</td>
                  <td>订单号</td>
				   <td>客户姓名</td>
				  <td>客户联系电话</td>
				  <td>配送地址</td>
				 <td>操作</td>
				</tr>
			</thead>
			<tbody style="font-size: 25px;line-height:70px;">
		
				<tr class="tr" >
					<!-- foreach -->
					<?php foreach($meorder as $key=>$value): ?>
						<tr class="gradeX">
						  <td><?= Html::encode($value['order_id']) ?></td>
						  <td><?= Html::encode($value['order_sn']) ?></td>
						  <td><?= Html::encode($value['site_name']) ?></td>
						  <td><?= Html::encode($value['site_phone']) ?></td>
						  <td><?= Html::encode($value['site_detail']) ?></td>
						  <td class="dao_<?= Html::encode($value['order_id']) ?>">
								<?php if($value['order_status']==3): ?>
									<?= "已经送达" ?>
								<?php else: ?>
									<button value="<?= Html::encode($value['order_id']) ?>" class="btn btn-inverse add">点此送达</button>
								<?php endif; ?>
						  </td>
						</tr>
					<?php endforeach; ?>
				</tr>
				
			
			</tbody>
		</table>
	</div>
</div>
<input type="hidden" name="userid" value="<?= Html::encode($userid) ?>">
<audio src="./music/dream.mp3" controls="controls"   style="display:none;"></audio>

<script>
//送达
$(document).on("click",".btn",function(){
	var id = $(this).attr("value");
	$.ajax({
	   type: "GET",
	   url: "<?= Url::to(['distribution/dao']); ?>",
	   data: "id="+id,
	   success: function(msg){
			if(msg['code'] ==200){
				$(".dao_"+id).html("已经送达");
			}else{
				alert('操作失败');
			}
	   }
	});
});
//抢单
$(".qiang").click(function(){
	var id = $(this).parent().attr("value");
	userid = $("input[name=userid]").val();
	location.href="<?=  Url::to(['distribution/addorder']); ?>&id="+id+"&userid="+userid;
});



$(document).ready(function(){
	// data.get();
});
var data = {
	get:function(){	
	$.ajax({
			type: "GET",
			url: "<?php echo Url::to(['order/getkitchen']);?>",
			dataType: 'json',
			success: function(msg){
				if (msg.code == 200)
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

</script>
<script>
function myrefresh(){
window.location.reload();
}
setTimeout('myrefresh()',10000); 
</script>
<script type="text/javascript">
$(function(){
// 给head里面元素绑定鼠标点击事件
	$('.head_son').click(function(){
	// 获取当前元素的序号
		var num = $(this).index();
		// 当前的序号的色块显示
		$('.foot_son').eq(num).css({'display':"block"});
		// 其兄弟元素隐藏
		$('.foot_son').eq(num).siblings('.foot_son').css({'display':"none"});
	})

	//开始制作
	$('.start').click(function(){
	
		var orderid=$(this).attr('orderid');
		var tr=$(this).parents('tr').css({'display':"none"});
			$.ajax({
			type: "GET",
			url: "<?php echo Url::to(['order/startkitchen']);?>",
			data:{orderid:orderid},
			dataType: 'json',
			success: function(msg){
				if (msg.code == 200)
				{
				tr.css({'display':"none"});
				}
			}
		});
	})

	//完成制作
	$('.end').click(function(){
		var id=$(this).attr('status');
		var over=$(this).css({'display':"none"});
			$.ajax({
			type: "GET",
			url: "<?php echo Url::to(['order/endkitchen']);?>",
			data:{id:id},
			dataType: 'json',
			success: function(msg){
				if (msg.code == 200)
				{
				over.css({'display':"none"});
				}
			}
		});
	})


})

</script>

