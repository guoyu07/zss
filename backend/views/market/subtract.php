<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '满减列表';
?>

<style type="text/css">
	label{display:none}
</style>
<link rel="stylesheet" href="./assets/order/lab.css" />
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>满减列表</h5>
          </div>
		  <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
		  <div id="searchdiv">
		  <a href="<?= yii::$app->urlManager->createUrl(['market/add_subtract'])?>"><button class="btn-primary btn" >添加</button></a>
		  <button class="btn btn-info" id="delall">删除</button>
		  <button class="che btn  btn-info" id="checkall">全选</button>
		  </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
				  <th></th>
                  <th>ID</th>
                  <th>满</th>
                  <th>减</th>
				  <th>是否显示</th>
				  <th>修改人</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
			<?php foreach($models as $model):?>
                <tr class="gradeX" id="a_<?= Html::encode($model['subtract_id'])?>">
				  <td> <input type="checkbox" class="choall"  value="<?=Html::encode($model["subtract_id"])?>" name="checkbox"></td>
				  <td>
				  <?= Html::encode($model['subtract_id']);?>
				 </td>
                  <td><?= Html::encode($model['subtract_price'])?></td>
                  <td><?= Html::encode($model['subtract_subtract'])?></td>
				  <td><?= Html::encode($model['username'])?></td>
				  <td class="show_<?= Html::encode($model['subtract_id'])?>" id="changeShow" name="<?= Html::encode($model['subtract_id'])?>" value="<?= Html::encode($model['subtract_show'])?>">
					<?php if($model['subtract_show'] == 1){
						echo "<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>";
					}else{
						echo "<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>";
					}
					?>
				  </td>
				  <td>
				   <img src="assets/img/search.png" id="moreinfo_<?= Html::encode($model['subtract_id'])?>" style="cursor:pointer;width:20px;height:20px" onclick="getmoreinfo(<?= Html::encode($model['subtract_id'])?>)"/> 
				  <a href="?r=market/upd_subtract&id=<?= Html::encode($model['subtract_id'])?>">
				  <img src="assets/img/edit.png" id="updatesubtract" value="<?= Html::encode($model['subtract_id'])?>" style="cursor:pointer;"/> 
				  </a>
				  <img src="assets/img/delete.png" class="delsubtrace" id="<?= Html::encode($model['subtract_id'])?>" style="cursor:pointer;"/>
				  </td>
                </tr>       
			<?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
<!---->
<div style="display:none">
    <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体"></table>
</div>
<!---->
<!---遮罩层 start -->
<div id="bg"></div>
<div id="show">	
		
</div>
<!----遮罩层 end --->
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
	function hidediv() {
			   $("#bg").hide();
				$("#show").hide();
	}


//删除选中的满减
	$(document).on("click",".delsubtrace",function(){
		//询问框
		id = $(this).attr("id");
		layer.confirm('您确定要删除吗？', {
		  btn: ['删除','取消'] //按钮
		}, function(){	
			$.get("<?= yii::$app->urlManager->createUrl(['market/delsubtrace'])?>",{id:id},function(data){
				if(data.data == 1){
					$("#a_"+id).remove();
					layer.msg('删除成功', {icon: 1});
					$("#"+id).remove();
					}
					if (data.data == 0)
					{
						layer.msg('删除失败', {icon: 1});
					}
			});
		}, function(){
			//取消执行
		});
	});



$(document).ready(function(){
    $("#small").toggle(function(){
            $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
          },function(){
            $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
     });
})


///点击修改显示状态
	$(document).on("click","#changeShow",function(){
		id = $(this).attr("name")
		show = $(this).attr("value");
			if(show == 1){
				$(".show_"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
				$.get("<?= yii::$app->urlManager->createUrl(['market/changesubtract'])?>",{id:id,show:show},function(msg){
					if(msg.data == 0){
						//alert("error")
						$(".show_"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
					}else{
						$(".show_"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
						$(".show_"+id).attr("value",0);
						}
				});
			}
			if(show == 0){
			$(".show_"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
			$.get("<?= yii::$app->urlManager->createUrl(['market/changesubtract'])?>",{id:id,show:show},function(msg){
					if(msg.data == 0){
						alert("error")
						$(".show_"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
					}else{
						$(".show_"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
						$(".show_"+id).attr("value",1);
						}
				});
			}
})
	//单击查询选中的详情信息
	function getmoreinfo(id)
	{
			$.ajax({
				   type: "GET",
				   url: "<?= Yii::$app->urlManager->createUrl(['market/getonesubtract']) ?>",
				   data: "id="+id,
					beforeSend: function(){
							loading(1);
					},
					complete: function(){
						loading(0);
					},
				   success: function(msg){
						$("#show").html(msg.data);
						$("#bg").show();
						$("#show").show();
				   }
			});
	}






	//批量删除
	$(document).on("click","#delall",function(){
		var str="";
            $("input[name='checkbox']:checkbox").each(function(){ 
                if($(this).attr("checked")){
                    str += $(this).val()+","
                }
            })
			if(str == ''){
				layer.msg('请选中要删除的值', {icon: 2});
			}else{
				$.get("<?= yii::$app->urlManager->createUrl(['market/dellallsubtract'])?>",{str:str},function(msg){
					if(msg.code==200){
						history.go(0)
					}else{
						layer.msg('删除失败', {icon: 2});
						}
				})
			}
	})
  //全选
         $(".che").toggle(
            function () {
              $(".choall").attr("checked",true);
            },
            function () {
              $(".choall").attr("checked",false);
            }
          );
	</script>