<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '抢单页面'; 
?>
<style type="text/css">
body{#f9f9f9}
#act img{ cursor:pointer; }
.but{	padding:7px;}
.but  button{ margin-left:15px }
#status{ width:20px; height:20px; cursor:pointer;}
</style>

<?= Html::jsFile('./assets/order/layer/layer.js')?>
<?= Html::cssFile('./assets/order/lab.css')?>
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>配送员中心</h5>
          </div>
		  <div style="padding-left:15px;">
			<h5>欢迎&nbsp;<?= Html::encode($shop['admin_name']) ?>&nbsp;登陆&nbsp;&nbsp;&nbsp;您所在的门店是：<?= Html::encode($shop['shop_name']) ?></h5>
		 </div>
		 <input type="hidden" name="userid" value="<?= Html::encode($userid) ?>">
		 <!--展开 收起  start -->
		 <!--
		  <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
			<div id="searchdiv">
				 <button class="btn btn-inverse add">添加配送员</button>
				 <button class="btn btn-info" id="del_button">删除</button>
				 <button class="che btn btn-info">全选</button>
				<div id="search">
					<input type="text" placeholder="请输入配送员的名称..." id="word"/>
					<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
				</div>
			</div>
		 -->
		 <!--展开 收起  end -->
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style=" font-size:14px;">
            <thead>
                <tr>
                  <th>订单ID</th>
                  <th>订单号</th>
				  <th>客户姓名</th>
				   <th>取餐号</th>
				  <th>客户联系电话</th>
				  <th>配送地址</th>
                  <th>操作</th>
                </tr>
             </thead>
              <tbody>
				<!-- foreach -->
				<?php foreach($data as $key=>$value): ?>
					<tr class="gradeX">
					  <td><?= Html::encode($value['order_id']) ?></td>
					  <td><?= Html::encode($value['order_sn']) ?></td>
					  <td><?= Html::encode($value['site_name']) ?></td>
					  <td><?= Html::encode($value['meal_number']) ?></td>
					  <td><?= Html::encode($value['site_phone']) ?></td>
					  <td><?= Html::encode($value['site_detail']) ?></td>
					  <td value="<?= Html::encode($value['order_id']) ?>"><button class="btn btn-inverse qiang">抢单</button></td>
					</tr>
				<?php endforeach; ?>
				<!-- endforeach -->
              </tbody>
            </table>
          </div>
        </div>
<div style="display:none">
    <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体"></table>
</div>
<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
<img id="loading" src="./assets/order/load.gif" style="z-index:20000; background-color:rgba(0,152,50,0.7); display:none; z-index:999; position:fixed; top:55%; margin-top:-100px; left:45%">
<script type="text/javascript">
 $(".che").toggle(
            function () {
              $(".one").attr("checked",true);
            },
            function () {
              $(".one").attr("checked",false);
            }
          );

//loading
function loading(num){
	if(num==1){
		$("#loading").show();
	}else{
		$("#loading").hide();
	}
}

function deletedata(){
	$("input[name=checkdel]:checked").each(function(){
		$(this).parent().parent().parent().parent().remove();
	})
}

$("#small").toggle(function(){
		$("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
		$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
	  },function(){
		$("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
		$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
 });

$("#all").click(function(){  
        if(this.checked){  
            $("input[type=checkbox]").prop("checked",true);     
        }else{      
            $("input[type=checkbox]").prop("checked",false);   
        }      
});  

//抢单
$(".qiang").click(function(){
	var id = $(this).parent().attr("value");
	userid = $("input[name=userid]").val();
	location.href="<?=  Url::to(['distribution/addorder']); ?>&id="+id+"&userid="+userid;
});
</script>