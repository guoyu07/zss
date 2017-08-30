<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '门店列表'; 
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
            <h5>门店列表</h5>
          </div>
		 <!--展开 收起  start -->
		 <!--
		 <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
			<div id="searchdiv">
				<div id="search">
					<input type="text" placeholder="请输入门店名称或地址..." id="word"/>
					<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
				</div>
			</div>
		 -->
		 <!--展开 收起  end -->
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style=" font-size:14px;">
            <thead>
                <tr>
				  <th><input type="checkbox"></th>
                  <th>ID</th>
                  <th>门店名称</th>
                  <th>营业状态</th>
				  <th>门店地址</th>
				  <th>门店电话</th>
				  <th>经度</th>
				  <th>纬度</th>
                  <th>操作</th>
                </tr>
             </thead>
              <tbody>
				<?php foreach($models as $k=>$model): ?>
                <tr class="gradeX">
				  <td><input type="checkbox" name="checkdel" value="<?= $model['shop_id']; ?>"><input type="hidden" value='a'></td>
                  <td><?= Html::encode($model['shop_id']); ?></td>
                  <td><?= Html::encode($model['shop_name']); ?></td>
                  <td style="width:5%">
					<?php if(Html::encode($model['shop_status'])==1): ?>
						<img id="status" class="<?= $model['shop_id']; ?>" value="1" src="./assets/ico/png/34.png">
					<?php else: ?>
						<img id="status" class="<?= $model['shop_id']; ?>" value="0"  src="./assets/ico/png/40.png">
					<?php endif; ?>
				  </td>
				  <td style="width:20%;"><?= Html::encode($model['shop_address']); ?></td>
				  <td><?= Html::encode($model['shop_tel']); ?></td>
				   <td><?= Html::encode($model['shop_x']); ?></td>
				    <td><?= Html::encode($model['shop_y']); ?></td>
                  <td id="act" style="width:10%">
					<img width=20 height=20 value="<?= Html::encode($model['shop_id']); ?>" id="shop" src="./assets/order/search.png" alt="门店信息查看" title="门店信息查看"/>
				  </td>
                </tr>   
				<?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
<input type="hidden" name="user_id" value="<?= $id ?>">
<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
<img id="loading" src="./assets/order/load.gif" style="z-index:20000; background-color:rgba(0,152,50,0.7); display:none; z-index:999; position:fixed; top:55%; margin-top:-100px; left:45%">
<script type="text/javascript">
//loading
function loading(num){
	if(num==1){
		$("#loading").show();
	}else{
		$("#loading").hide();
	}
}
//批量删除
$(document).on("click","#del_button",function(){
	var str = '';
	var n = '';
	$("input[name=checkdel]:checked").each(function(){
		str += n+$(this).val();
		n = ",";
	})
	//询问框
	layer.confirm('您确定要批量删除吗？', {
	  btn: ['删除','取消'] //按钮
	}, function(){
		$.ajax({
		   type: "GET",
		   url: "<?= Yii::$app->urlManager->createUrl(['shop/delete-all']);  ?>",
		   data: "str="+str,
		   success: function(msg){
				if(msg['code'] ==200){
					 layer.msg('删除成功', {icon: 1});
					  deletedata();
				}else{
					 layer.msg('删除失败', {icon: 0});
				}
		   }
		});
	}, function(){
	});
});
function deletedata(){
	$("input[name=checkdel]:checked").each(function(){
		$(this).parent().parent().parent().parent().remove();
	})
}


//删除
$(document).on("click","#delete",function(){
	id = $(this).attr("value");
	//询问框
	layer.confirm('您确定要删除吗？', {
	  btn: ['删除','取消'] //按钮
	}, function(){
		$.ajax({
		   type: "GET",
		   url: "<?= Yii::$app->urlManager->createUrl(['shop/delete']);  ?>",
		   data: "id="+id,
		   success: function(msg){
				if(msg['code'] ==200){
					$('.del'+id).parent().parent().remove();
					 layer.msg('删除成功', {icon: 1});
				}else{
					 layer.msg('删除失败', {icon: 0});
				}	 
		   }
		});
	}, function(){
	});
});
$(document).on("click",".add",function(){
	location.href="<?= Yii::$app->urlManager->createUrl(['shop/add']); ?>";
});
//编辑
function showdiv(id) {
	location.href="<?= Yii::$app->urlManager->createUrl(['shop/edit']); ?>&id="+id;
}
$("#small").toggle(function(){
		$("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
		$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
	  },function(){
		$("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
		$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
 });

//修改门店状态
 $(document).on("click","#status",function(){
	status = $(this).attr("value");
	shop_id = $(this).attr("class");
	csrf = $("#_csrf").val();
	$.ajax({
	   type: "POST",
	   url: "<?= Yii::$app->urlManager->createUrl(['shop/shop-status']); ?>",
	   data: "status="+status+"&shop_id="+shop_id+"&_csrf="+csrf,
	   success: function(msg){
			if(msg['code']==400){
				location.reload();
				layer.msg('修改失败', {icon:0});
			}else{
				//layer.msg('修改成功', {icon:1});
				if(status==1){
					$("."+shop_id).attr("value",0);
					$("."+shop_id).attr("src","./assets/ico/png/40.png");
				}else if(status==0){
					$("."+shop_id).attr("value",1);
					$("."+shop_id).attr("src","./assets/ico/png/34.png");
				}
			}
	   }
	});
 })

//门店信息查看
$(document).on("click","#shop",function(){
	id = $(this).attr("value");
	location.href="<?= Yii::$app->urlManager->createUrl(['shop/shoper-shop']); ?>&id="+id+"&user_id="+$("input[name=user_id]").val();
});

//模糊查询
$(document).on("click",".tip-bottom",function(){
	word = $("#word").val();
	if(word != ''){
		$.ajax({
		   type: "GET",
		   url: "<?= Yii::$app->urlManager->createUrl(['shop/search-shop']); ?>",
		   data: "word="+word+"&id=",
		   beforeSend: function(){
				loading(1);
			},
			complete: function(){
				loading(0);
			},
		   success: function(msg){
				$(".widget-content").html(msg);
		   }
		});
	}
});
</script>