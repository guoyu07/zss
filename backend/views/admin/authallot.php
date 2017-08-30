<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>


<div class="widget-box">
         <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
         <h5>更改列表</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
    </div>
</div>	
		<?php 
			$form = ActiveForm::begin([
				'options' => ['class' => 'form-horizontal',
				'id'=>'type-form'],
				'action'=>Url::to(['admin/rolenodecreate']),
				'method'=>'post',
				'fieldConfig' => [
					'template' => '<div class="form-group"><center><label class="col-md-2 control-label" for="type-name-field">{label}</label></center><div class="col-md-8 controls">{input}{error}</div></div>'
				], 
			]);
		?>
	
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

						<tr style="valign:middle;">
							<th>可分配的权限</th>
							<td>
								<?php foreach($auth as $key => $val){?>
									<?php if($val['is_checked'] == 1){?>
										<li style="width:170px;height:25px;display:block;clear:both;"><?= Html::checkbox('node_id[]', 'checked',['class' => 'che check'.$val['node_id'],'value' => $val['node_id'],'style'=>'clear:both;']) ?>&nbsp;&nbsp;&nbsp;<?= Html::encode($val['node_title']) ?></li>
									<?php }else{ ?>
										<li style="width:170px;height:25px;display:block;clear:both;"><?= Html::checkbox('node_id[]', null,['class' => 'che check'.$val['node_id'],'value' => $val['node_id'],'style'=>'clear:both;']) ?>&nbsp;&nbsp;&nbsp;<?= Html::encode($val['node_title']) ?></li>
									<?php }?>
									<?php if(isset($val['node'])) { ?>
										<?php foreach($val['node'] as $k => $v){?>
											<?php if($v['is_checked'] == 1){?>
												<li style="display:block;float:left;margin-left:40px;width:140px;height:25px;"><?= Html::checkbox('node_id[]', 'checked',['class' => 'che'.$val['node_id'].' check','value' => $v['node_id'], 'p_id' =>$val['node_id'] ]) ?>&nbsp;&nbsp;&nbsp;<?= Html::encode($v['node_title']) ?></li>
											<?php }else{ ?>
												<li style="display:block;float:left;margin-left:40px;width:140px;height:25px;"><?= Html::checkbox('node_id[]', null,['class' => 'che'.$val['node_id'].' check','value' => $v['node_id'], 'p_id' =>$val['node_id'] ]) ?>&nbsp;&nbsp;&nbsp;<?= Html::encode($v['node_title']) ?></li>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php }?>
							</td>
							
						</tr>
						
					</tbody>
				</table>
			
			<div class="modal-footer">	
				<button data-dismiss="modal" class="btn" type="button"  onclick="hidediv();" >关闭</button>
				<?= Html::submitButton('添加', ['class' => 'btn btn-success','id'=>'category-create-btn']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<script type="text/javascript">
	//全选
	$(document).on("click",".che",function(){
		var val = $(this).val()
		if($(this).prop("checked")==true){
			$(".che"+val).prop("checked",true);
		}else{
			$(".che"+val).prop("checked",false);
		}
	});
	//选择父节点
	$(document).on("click",".check",function(){
		var val = $(this).attr('p_id')
		if($(this).prop("checked")==true){
			$(".check"+val).prop("checked",true);
		}
	});
</script>