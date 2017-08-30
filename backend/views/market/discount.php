<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '折扣列表';
?>
<script src="layer/layer.js"></script> 

<style type="text/css">
	label{display:none}
</style>
<link rel="stylesheet" href="./assets/order/lab.css" />

<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>折扣列表</h5>
          </div>
	 <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
	 <div id="searchdiv">
		 <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/adddiscount'])?>">
		 <button class="btn-primary btn" >添加折扣</button></a>&nbsp;&nbsp;
		  <button class="btn btn-info" id="delall">删除</button>&nbsp;&nbsp;
		  <button class="che btn  btn-info" id="checkall">全选</button>
		</div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
				  <th></th>
                  <th>ID</th>
                  <th>折扣</th>
				  <th>是否显示</th>
				  <th>修改人</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>

			  <!--显示已用的折扣-->
			  <?php foreach($use as $k=>$v){?>
			  <?php $id = $v['discount_id'];?>
                <tr class="gradeX" id="hang_<?php echo $id?>">
				  <td><input type="checkbox" class="choall"  value="<?=Html::encode($v["discount_id"])?>" name="checkbox"></td>
                  <td class="id_<?php echo $id?>">
				  <?= Html::encode($v['discount_id'])?>
				  </td>
                  <td class="num_<?php echo $id?>">
				  <span class="number"><?= Html::encode($v['discount_num']);?></span> <span>%</span>
				  </td>
				  <td class="show_<?= Html::encode($v['discount_id'])?>" id="changeShow" name="<?= Html::encode($v['discount_id'])?>"value="<?= Html::encode($v['discount_show'])?>">
					<?php if(Html::encode($v['discount_show'])==1){
						echo "<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>";
					}else{
						echo "<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>";
					}?>
				  </td>
				  <td >
				  <?= Html::encode($v['username']);?>
				  </td>
				  <td>
				  <img src="assets/img/search.png" id="moreinfo_<?= Html::encode($v['discount_id'])?>" style="cursor:pointer;width:20px;height:20px" onclick="getmoreinfo(<?= Html::encode($v['discount_id'])?>)"/> 
				   <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/upd_discount','id'=>Html::encode($v['discount_id'])])?>">
				  <img src="./assets/img/edit.png" id="updatediscount" value="<?= Html::encode($v['discount_id'])?>" 
				  style="cursor:pointer;"/> 
				  </a>
				  <img src="./assets/img/delete.png" id="deldiscount" value="<?= Html::encode($v['discount_id'])?>" style="cursor:pointer;"/>
				  </td>
                 
                </tr>   
				<?php };?>
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



	$(document).on("click","#deldiscount",function(){
		
		id = $(this).attr("value");
		layer.confirm('您确定要删除吗？', {
		  btn: ['删除','取消'] //按钮
		}, function(){	
			$.get("<?= yii::$app->urlManager->createUrl(['market/deldiscount'])?>",{id:id},function(data){
				if(data.data == 1){
					
					layer.msg('删除成功', {icon: 1});
					$("#hang_"+id).remove();
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


	//点击改变显示状态
	$(document).on("click","#changeShow",function(){
		id = $(this).attr("name")
		show = $(this).attr("value");
			if(show == 1){
				$(".show_"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
				$.get("<?= yii::$app->urlManager->createUrl(['market/changedisocunt'])?>",{id:id,show:show},function(msg){
					if(msg.data == 0){
						alert("error")
						$(".show_"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
					}else{
						$(".show_"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
						$(".show_"+id).attr("value",0);
						}
				});
			}

			if(show == 0){
			$(".show_"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
			$.get("<?= yii::$app->urlManager->createUrl(['market/changedisocunt'])?>",{id:id,show:show},function(msg){
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

	//点击获取更多详情
	function  getmoreinfo(id)
	{
			$.ajax({
				   type: "GET",
				   url: "<?= Yii::$app->urlManager->createUrl(['market/getonediscount']) ?>",
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
				$.get("<?= yii::$app->urlManager->createUrl(['market/dellalldiscount'])?>",{str:str},function(msg){
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
