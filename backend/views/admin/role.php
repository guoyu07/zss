<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '角色管理';
?>
<?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>
<?= Html::cssFile('./assets/order/lab.css')?>
<?= Html::cssFile('./assets/order/xia.css')?>
<?= Html::jsFile('./assets/order/layer.js')?>

  
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>角色管理</h5>
          </div>
		  <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
		 <div id="searchdiv">
		 <button class="add_role btn-primary" style="width:100px;height:30px" onclick="showdiv()">添加角色</button>
		</div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
				<thead>
					<tr>
						<th>角色名称</th>
						<th>状态</th>
						<th>角色信息</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if($data){?>
					<?php foreach($data as $key => $val){?>
						<tr id="user-table-tr-14" id="hang_<?php echo Html::encode($val['role_id'])?>">
							<td>
								<strong>
									<?= Html::encode($val['role_name']) ?>
								</strong>
							</td>
							<td>
								<?php if($val['role_status'] == '1'){?>
									<span id="<?php echo Html::encode($val['role_id'])?>" class="On">
									<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>
									</span>
								<?php }else{?>
									<span id="<?php echo Html::encode($val['role_id'])?>" class="Off">
									<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>
									</span>
								<?php }?>
							</td>
							<td>
								<span class="text-muted text-sm">
									<?php if($val['role_remark']){?>
										<?php echo Html::encode($val['role_remark']) ?>
									<?php }else{
										echo "--";
									}?>
								</span>
							</td>
							<td>
								<img src="assets/img/edit.png" class="promote-user" href="javascript:void(0)" data-toggle="modal" data-target="#RoleUpdate" type="<?= Html::encode($val['role_id'])?>" style="cursor:pointer;margin-right:10px" id="Edit"/>
								<img src="assets/img/delete.png" class="promote-user Delete" name="<?= Html::encode($val['role_id'])?>" style="cursor:pointer;margin-right:10px"/>
								<img src="assets/img/add.png" class="promote-user" href="javascript:void(0)" data-toggle="modal" data-target="#RoleUpdate" type="<?= Html::encode($val['role_id'])?>" style="cursor:pointer;width:20px;height:20px" id="Auth"/>
									
							</td>
						</tr>
					<?php }}else{?>
						<tr>
							<td colspan="20">
								<div class="empty">暂无角色记录</div>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
          </div>
        </div>
<div style="display:none">
<div id="addRole" class="modal fade">
<div class="widget-box">
         <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
         <h5>添加列表</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
    </div>
</div>

<div ></div>

				<?php 
					$form = ActiveForm::begin([
						'options' => ['class' => 'form-horizontal',
						'id'=>'Users-form'],
						'action'=>Url::to(['admin/rolecreate']),
						'method'=>'post'
					]);
				?>
				 <table align="center">
              <tr>	
                  <td>名称:</td><td><?= $form->field($model, 'role_name',['inputOptions'=>['placeholder'=>'请输入角色名称']])->textInput(['maxlength' => true,"style"=>"height:35px;"]) ?></td>
              </tr>	
              <tr>	
                  <td>状态:</td>
				  <td>	
					<input type="radio" name="AuthRole[role_status]" checked value=1>开启
					<input type="radio" name="AuthRole[role_status]" value=0>禁用
				</td>
              </tr>
			  <tr>
				<td>信息名称：</td>
				<td>
				<?= $form->field($model, 'role_remark',['inputOptions'=>['placeholder'=>'请输入角色信息名称']])->textInput(['maxlength' => true,"style"=>"height:35px;"]) ?>
				</td>
			  </tr>
				<br>
				<tr>	
					<td></td>
                    <td >
					<?= Html::submitButton('保存', ['class' => 'btn btn-primary','id'=>'user-create-btn']) ?></td><td></td>
                 </tr>			
				 </table>
				<?php ActiveForm::end(); ?>



</div>
</div>

<!---遮罩层 start -->
<div id="bg"></div>
<div id="show" style="width:600px;height:300px;margin-top:90px;margin-left:150px" >	
		
</div>
<!----遮罩层 end --->
<img id="loading" src="./assets/order/load.gif" style="z-index:20000; background-color:rgba(0,152,50,0.7); display:none; z-index:999; position:fixed; top:55%; margin-top:-100px; left:45%">


<script>

	//弹出和隐藏
		$("#small").toggle(function(){
				$("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
				$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
			  },function(){
				$("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
				$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
		 });


//弹出遮罩层显示数据
	function showdiv() {
			msg = $("#addRole").html();
			$("#bg").show();
			$("#show").html(msg);
			$("#show").show();
		}

	function hidediv() {
			msg = $("#addRole").html();
			$("#bg").hide();
			$("#show").hide();
	}

	//loading
	function loading(num){
		if(num==1){
			$("#loading").show();
		}else{
			$("#loading").hide();
		}
	}
	//修改
	$(document).on("click","#Edit",function(){
		var role_id = $(this).attr('type');
		$.ajax({
			type: "get",
			url: "<?php echo Url::to(['admin/roleupdate']);?>",
			data: "role_id="+role_id+"&type=list",
			dataType: 'json',
			beforeSend: function(){
				//$("#bg").show();
				//loading(1);
			},
			complete: function(){
				//$("#bg").hide();
				//loading(0);
			},
			success: function(msg){
				if (msg.code == 200)
				{
					$("#bg").show();
					$("#show").html(msg.data);
					$("#show").show();
				}else if(msg.code == 403)
				{
					$("#bg").show();
					$("#show").html('<div class="modal-dialog " style="width:170px;"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title"><font color="red">'+msg.msg+'</font></h4></div></div></div>');
					$("#show").show();
				}
			}
		});
	})
	//删除
	$(".Delete").click(function(){
		if(confirm("您确定要删除这条记录？")){
			var role_id=$(this).attr("name");
			$(this).parent().parent().remove()
			$.ajax({
				type: "get",
				url: "<?php echo Url::to(['admin/roledelete']);?>",
				data: "role_id="+role_id,
				dataType: 'json',
				success: function(msg){
					if (msg.code == 200) {
						history.go(0)
					}else if(msg.code == 400)
					{
						layer.msg('删除失败', {icon: 2});
					}else if(msg.code == 403) 
					{
						layer.msg('暂无权限', {icon: 0});
					}
				}
			});
		}
	})
	
	//点击开启
	$(document).on("click",".On",function(){
		var id = $(this).attr('id');
		$("#"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
		$.ajax({
			type: "GET",
			url: "<?php echo Url::to(['admin/rolestatus']);?>",
			data: "id="+id+"&status=0",
			success: function(msg){
				console.log(msg)
				if(msg.code == 400)
				{
					alert("修改失败")
					$("#"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
				}else if(msg.code == 403) 
				{
					alert('暂无权限')
					$("#"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
				}else{
					$("#"+id).attr("class","Off")
					$("#"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
				}

			}
		});
	})
	//点击禁用
	$(document).on("click",".Off",function(){
		var id = $(this).attr('id');
		$("#"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
		$.ajax({
			type: "GET",
			url: "<?php echo Url::to(['admin/rolestatus']);?>",
			data: "id="+id+"&status=1",
			success: function(msg){
				console.log(msg)
				if(msg.code == 400)
				{
					alert("修改失败")
					$("#"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
				}else if(msg.code == 403) 
				{
					alert('暂无权限')
					$("#"+id).html("<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>")
				}else{
					$("#"+id).attr("class","On")
					$("#"+id).html("<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>")
				}

			}
		});
	})



	//分配权限
	$(document).on("click","#Auth",function(){
		var role_id = $(this).attr('type');
		$.ajax({
			type: "get",
			url: "<?php echo Url::to(['admin/authallot']);?>",
			data: "role_id="+role_id,
			dataType: 'json',
			beforeSend: function(){
				//$("#bg").show();
				//loading(1);
			},
			complete: function(){
			//	$("#bg").hide();
			//	loading(0);
			},
			success: function(msg){
				if (msg.code == 200)
				{	
					$("#bg").show();
					$("#show").html(msg.data);
					$("#show").show();
				}else if(msg.code == 403) 
				{
					$("#bg").show();
					$("#Auth").html('<div class="modal-dialog " style="width:170px;"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title"><font color="red">'+msg.msg+'</font></h4></div></div></div>');
					$("#show").show();
				}
			}
		})
	})
	
	 //添加提示
		buer = $("#errorfix").val()
		  //alert(buer)
		if (buer) {
		   layer.msg(buer)
		}
</script>	