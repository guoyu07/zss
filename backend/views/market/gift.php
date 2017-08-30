<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '红包管理';
?>

<style type="text/css">

	label{display:none}
</style>

<script src="<?php echo yii::$app->request->baseUrl;?>/js/"></script>
<link rel="stylesheet" href="./assets/order/lab.css" />

<div class="widget-box" >
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>赠品管理</h5>
          </div>
		<div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
	 <div id="searchdiv">
		 <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/addgift'])?>">
		  <button class="add_gift btn-primary btn" >添加赠品</button>&nbsp;&nbsp;
		  </a>
		  <button class="btn btn-info" id="delall">删除</button>&nbsp;&nbsp;
		  <button class="che btn  btn-info" id="checkall">全选</button>
     <!--start-top-serch-->
    <div id="search">
      <input type="text" placeholder="搜索红包名称" id="word"/>
      <button type="submit" class="tip-bottom" title="Search" id="clickTOget"><i class="icon-search icon-white"></i></button>
    </div>
    <!--close-top-serch-->
	  </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
				  <th></th>
                  <th>ID</th>
                  <th>名称</th>
				  <th>库存</th>
                  <th>赠品单价</th>
				  <th>是否显示</th>
				  <th>修改人</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody id="tbody">
		<?php	foreach ($model as $v):?>
				
                <tr class="gradeX" id="hang_<?= Html::encode($v['gift_id'])?>">
				  <td>  
				  <input type="checkbox" class="choall"  value="<?=Html::encode($v["gift_id"])?>" name="checkbox">
				  </td>
				  <td><?= Html::encode($v['gift_id'])?></td>
				  <td><?=Html::encode($v["gift_name"])?></td>
				  <td><?=Html::encode($v["gift_num"])?></td>
				  <td><?=Html::encode($v["gift_price"])?></td>

				  <td class="show_<?= Html::encode($v['gift_id'])?>" id="changeShow" name="<?= Html::encode($v['gift_id'])?>"value="<?= Html::encode($v['gift_show'])?>">
				<?php if(Html::encode($v['gift_show'])== 1 ){
					echo "<img src='assets/ico/ico/34.ico' style='width:20px;height:20px;cursor:pointer;'>";
				  } else{
					echo "<img src='assets/ico/ico/40.ico' style='width:20px;height:20px;cursor:pointer;'>";
				  }?>
				  </td>
				  <td><?= Html::encode($v['username'])?></td>
				  <td>
				  <img src="assets/img/search.png" id="moreinfo_<?= Html::encode($v['gift_id'])?>" style="cursor:pointer;width:20px;height:20px" onclick="getmoreinfo(<?= Html::encode($v['gift_id'])?>)"/> 
				  <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/updgift','id'=>Html::encode($v['gift_id'])])?>">
				  <img src="assets/img/edit.png" id="updategift" value="<?= Html::encode($v['gift_id'])?>" 
				  style="cursor:pointer;"/> 		
				  </a>
				  <img src="assets/img/delete.png" id="delwallet" value="<?= Html::encode($v['gift_id'])?>" style="cursor:pointer;"/>	
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

	$(document).on("click","#delwallet",function(){
		//询问框
		id = $(this).attr("value");
		
		layer.confirm('您确定要删除吗？', {
		  btn: ['删除','取消'] //按钮
		}, function(){	
			$.get("<?= yii::$app->urlManager->createUrl(['market/delgift'])?>",{id:id},function(data){
				if(data.data == 1){
					
					layer.msg('删除成功', {icon: 1});
					$("#hang_"+id).remove();
					}
					if (data.data == 0)
					{
						layer.msg('删除失败', {icon: 2});
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


	$(document).on("click","#changeShow",function(){
		id = $(this).attr("name")
		show = $(this).attr("value");
			if(show == 1){
				$(".show_"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
				$.get("<?= yii::$app->urlManager->createUrl(['market/changegiftshows'])?>",{id:id,show:show},function(msg){
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
			$.get("<?= yii::$app->urlManager->createUrl(['market/changegiftshows'])?>",{id:id,show:show},function(msg){
			
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


	//查询详细信息
	function getmoreinfo(id)
	{
			$.ajax({
				   type: "GET",
				   url: "<?= Yii::$app->urlManager->createUrl(['market/getonegift']) ?>",
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
				$.get("<?= yii::$app->urlManager->createUrl(['market/dellallgift'])?>",{str:str},function(msg){
					if(msg.code==200){
						history.go(0)
					}else{
						layer.msg('删除失败', {icon: 0});
						}
				})
			}
	})



	//关键字搜索
	$(document).on("click","#clickTOget",function(){
        var word = $("#word").val() 
			if(word == ''){
			layer.msg('请输入要搜索的赠品', {icon: 0});
		}else{
			$.get("<?= yii::$app->urlManager->createUrl(['market/seagiftinfo'])?>",{sea:word},function(msg){
				$("#tbody").html(msg.data)
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
