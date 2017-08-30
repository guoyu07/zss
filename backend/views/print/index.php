
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
            <h5>打印管理</h5>
          </div>
		 <!--展开 收起  start -->
		 <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
			<div id="searchdiv">
			<a href="<?= Url::to(['print/add'])."&shop_id=".$shop_id['shop_id']; ?>">添加打印机</a>
				 
			</div>
		 <!--展开 收起  end -->
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style=" font-size:14px;">
            <thead>
                <tr>
				  <th > id</th>
				   <th>档口名称</th>  
                  <th>打印机名称</th>                    
                  <th>操作</th>
                </tr>
             </thead>
              <tbody>
              <?php foreach ($model as $key => $value) {?>
	              <tr>
	              	  <th><?php echo $value['print_id']; ?></th>
	              	   <?php foreach ($value['series'] as $k => $v) {?>
		              		<th><?php echo $v['series_name']; ?></th> 
		              <?php } ?>
					  <th><?php echo $value['print_name']; ?></th>
					 		    
		              <th><a href="<?= Url::to(['print/del'])."&print_id=".$value['print_id']; ?>">删除</a></th>
	              </tr>
	           <?php } ?>
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
	location.href="<?= Yii::$app->urlManager->createUrl(['shop/shop']); ?>&id="+id;
});

//模糊查询
$(document).on("click",".tip-bottom",function(){
	word = $("#word").val();
	if(word != ''){
		$.ajax({
		   type: "GET",
		   url: "<?= Yii::$app->urlManager->createUrl(['shop/search-shop']); ?>",
		   data: "word="+word,
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

$("#all").click(function(){  
        if(this.checked){  
            $("input[type=checkbox]").prop("checked",true);     
        }else{      
            $("input[type=checkbox]").prop("checked",false);   
        }      
});  
</script>