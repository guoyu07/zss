<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '管理员管理';
?>  
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<div class="page-header clearfix">
				<h1 class="pull-left">管理员管理</h1>
				<div class="pull-right">
					<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Admin">添加管理员</a>
				</div>
			</div>
			<table id="user-table" class="table table-striped table-hover" data-search-form="#user-search-form" style="overflow:scroll; font-size:15px;font-family:楷体">
				<thead>
					<tr>
						<th>用户名</th>
						<th>Email</th>
						<th>注册时间</th>
						<th>最近登录</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if($data){?>
					<?php foreach($data as $key => $val){?>
						<tr id="user-table-tr-14">
							<td>
								<strong>
									<a href="javascript:;"><?= Html::encode($val['username']) ?></a>
								</strong>
								<?php if($val['status'] == "10"){?>
									<span id="<?php echo Html::encode($val['id']) ?>"><label class="label label-danger"></label></span>
								<?php }else{?>
									<span id="<?php echo Html::encode($val['id']) ?>"><label class="label label-danger">禁</label></span>
								<?php }?>
							</td>
							<td>
								<?php if($val['email']){
									echo Html::encode($val['email']);
								}else{
									echo "--";	
								}?><br>
							</td>
							<td>
								<span class="text-sm">
								<?php if($val['created_at']){
									echo date("Y-m-d H:i:s",Html::encode($val['created_at']));
								}else{
									echo "--";	
								}?></span>
							</td>
							<td>
								<span class="text-sm">
								<?php if($val['login_time']){
									echo date("Y-m-d H:i:s",Html::encode($val['login_time']));
								}else{
									echo "--";	
								}?></span>
								<br>
								<span class="text-muted text-sm">
									<?php if($val['login_ip']){?>
										<a class="text-muted text-sm" href="http://www.baidu.com/s?wd=<?php echo Html::encode($val['login_ip']) ?>" target="_blank"><?php echo Html::encode($val['login_ip']) ?></a>
									<?php }else{
										echo "--";
									}?>
								</span>
							</td>
							<td>
								<div class="btn-group">
									<a href="javascript:;"  class="btn btn-default btn-sm AdminInfo" data-toggle="modal" data-target="#AdminInfo" type="<?= Html::encode($val['id'])?>">查看</a>
									<a href="#" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a class="promote-user Role" href="javascript:" data-toggle="modal" data-target="#Role" type="<?= Html::encode($val['id'])?>">分配角色</a>
											<?php if($val['status'] == "10"){
											?>
												<a href="javascript:;"  class="promote-user Off" type="<?= Html::encode($val['id'])?>">禁用</a>
											<?php }else{ ?>
												<a href="javascript:;"  class="promote-user On" type="<?= Html::encode($val['id'])?>">启用</a>
												
											<?php }?>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					<?php }}else{?>
						<tr>
							<td colspan="20">
								<div class="empty">暂无管理员记录</div>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal" id="Admin">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">添加管理员</h4>
			</div>
			<div class="modal-body">
				<?php 
					$form = ActiveForm::begin([
						'options' => ['class' => 'form-horizontal',
						'id'=>'Users-form'],
						'action'=>Url::to(['admin/admincreate']),
						'method'=>'post',
						'fieldConfig' => [
							'template' => '<div class="form-group"><center><label class="col-md-2 control-label" for="type-name-field">{label}</label></center><div class="col-md-8 controls">{input}{error}</div></div>'
						], 
					]);
				?>
					
					<?= $form->field($model, 'username',['inputOptions'=>['placeholder'=>'请输入用户名']])->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'email',['inputOptions'=>['placeholder'=>'请输入邮箱']])->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'password_hash',['inputOptions'=>['placeholder'=>'请输入密码']])->passwordInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'password_re',['inputOptions'=>['placeholder'=>'请输入确认密码']])->passwordInput(['maxlength' => true]) ?>
					<div class="modal-footer">
						<?= Html::submitButton('保存', ['class' => 'btn btn-success','id'=>'user-create-btn']) ?>
						<button data-dismiss="modal" class="btn btn-link pull-right" type="button">取消</button>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="AdminInfo"></div>
<div class="modal" id="Role"></div>
<script type="text/javascript">
	//导出
	$("#export").click(function(){
		var admin=$(".admin").val();
		var admin_value=$("#admin_value").val();
		location.href="<?php echo \Yii::$app->urlManager->createUrl('admin/adminexport')?>&admin="+admin+"&admin_value="+admin_value;
	})
	//详情
	$(".AdminInfo").click(function(){
		var id = $(this).attr('type');
		$.ajax({
			type: "POST",
			url: "<?php echo Url::to(['admin/admininfo']);?>",
			data: "id="+id,
			dataType: 'json',
			success: function(msg){
				if (msg.code == 200)
				{
					$("#AdminInfo").html(msg.data);
				}else if(msg.code == 403)
				{
					$("#AdminInfo").html('<div class="modal-dialog " style="width:170px;"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title"><font color="red">'+msg.msg+'</font></h4></div></div></div>');
				}
			}
		});
	})
	//点击禁用
	$(document).on("click",".Off",function(){
		var id = $(this).attr('type');
		var self = $(this)
		$.ajax({
			type: "POST",
			url: "<?php echo Url::to(['admin/adminstatus']);?>",
			data: "id="+id+"&status=0",
			dataType: 'json',
			success: function(msg){
				if (msg.code == 200) {
					self.replaceWith('<a href="javascript:;"  class="promote-user On" type="'+id+'">启用</a>')
					$("#"+id).html('<label class="label label-danger">禁</label>')
				}else if(msg.code == 400)
				{
					alert("修改失败")
				}else if(msg.code == 403) 
				{
					alert('暂无权限')
				}
			}
		});
	})
	//点击启用
	$(document).on("click",".On",function(){
		var id = $(this).attr('type');
		var self = $(this)
		$.ajax({
			type: "POST",
			url: "<?php echo Url::to(['admin/adminstatus']);?>",
			data: "id="+id+"&status=10",
			dataType: 'json',
			success: function(msg){
				if (msg.code == 200) {
					self.replaceWith('<a href="javascript:;"  class="promote-user Off" type="'+id+'">禁用</a>')
					$("#"+id).html('<label class="label label-danger"></label>')
				}else if(msg.code == 400)
				{
					alert("修改失败")
				}else if(msg.code == 403) 
				{
					alert('暂无权限')
				}
			}
		});
	})
	//分配权限
	$(document).on("click",".Role",function(){
		var id = $(this).attr('type');
		$.ajax({
			type: "POST",
			url: "<?php echo Url::to(['admin/roleallot']);?>",
			data: "id="+id,
			dataType: 'json',
			success: function(msg){
				if (msg.code == 200)
				{
					$("#Role").html(msg.data);
				}else if(msg.code == 403)
				{
					$("#Role").html('<div class="modal-dialog " style="width:170px;"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title"><font color="red">'+msg.msg+'</font></h4></div></div></div>');
				}
			}
		});
	})
</script>