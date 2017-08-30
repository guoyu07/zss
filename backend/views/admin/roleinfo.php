<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>


<div class="modal-dialog " style="width:900px;">
	<div class="modal-content">
		<div class="modal-header">
			<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
			<h4 class="modal-title">权限详情</h4>
		</div>
			<div class="modal-body">
				<table class="table table-striped table-condenseda table-bordered">
					<tbody>
						<?= Html::input('hidden', 'role_id', $role_id) ?>
						<tr>
							<th width="15%">角色名称</th>
							<td width="85%"><?= Html::encode($role['role_name']) ?></td>
						</tr>

						<tr>
							<th>名称描述</th>
							<td><?= Html::encode($role['role_remark']) ?></td>
						</tr>
						<tr>

						<tr style="valign:middle;">
							<th>您的权限</th>
							<td>
								<?php foreach($auth as $key => $val){ ?>
									<?php if($val['is_checked'] == 1){ ?>
										<li style="width:170px;height:25px;display:block;clear:both;"><?= Html::encode($val['node_title']) ?></li>
									<?php } ?>
									<?php if($val['node']) { ?>
										<?php foreach($val['node'] as $k => $v){?>
											<?php if($v['is_checked'] == 1){ ?>
												<li style="display:block;float:left;margin-left:40px;width:120px;height:25px;"><?= Html::encode($v['node_title']) ?></li>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</td>
							
						</tr>
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">	
				<button data-dismiss="modal" class="btn btn-primary" type="button">关闭</button>
			</div>
	</div>
</div>