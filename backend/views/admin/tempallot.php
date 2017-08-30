<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<div class="widget-box">
<div class="modal-dialog " style="width:900px;">
	<div class="modal-content">
		  <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
                     <h5>临时权限详细信息</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" class="btn btn-inverse btn-mini"/>
          </div>
			<div class="modal-body">
				<table class="table table-striped table-condenseda table-bordered">
					<tbody>
						
						<tr>
							<th width="15%">管理员名称</th>
							<td width="85%"><?= Html::encode($admin['username']) ?></td>
						</tr>
						
						<tr style="valign:middle;">
							<th>可分配的角色</th>
							<td>
								<?php foreach($auth as $key => $val){?>
									<?php if($val['is_checked'] == 1){?>
										<li style="width:170px;height:25px;display:block;clear:both;"><?= Html::encode($val['node_title']) ?></li>
									<?php } ?>
									<?php if(isset($val['node'])) { ?>
										<?php foreach($val['node'] as $k => $v){?>
											<?php if($v['is_checked'] == 1){?>
												<li style="display:block;float:left;margin-left:40px;width:140px;height:25px;"><?= Html::encode($v['node_title']) ?></li>
											<?php } ?>
										<?php } ?>
									<?php }?>
								<?php } ?>
							</td>
						</tr>

						<tr>
							<th>结束时间</th>
							<td>
								<?= Html::encode(date('Y-m-d H:i:s',$temp_node[0]['node_temp_expire'])) ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>
</div>
</div>