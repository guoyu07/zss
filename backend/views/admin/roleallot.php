<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<style type="text/css">
label{ display:none;}
</style>  
<?php 
			$form = ActiveForm::begin([
				'options' => ['class' => 'form-horizontal',
				'id'=>'type-form'],
				'action'=>Url::to(['admin/adminrolecreate']),
				'method'=>'post',
				'fieldConfig' => [
					'template' => '<div class="form-group"><center><label class="col-md-2 control-label" for="type-name-field">{label}</label></center><div class="col-md-8 controls">{input}{error}</div></div>'
				], 
			]);
?>
<table border=1>
			<div class="widget-box">
          <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>分配权限</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
          </div>
          <div class="widget-content">
    
              <p></p>
<hr/>
                <?= Html::input('hidden', 'admin_id', $admin_id) ?>
                <p><button class="btn btn-inverse btn-mini"></button></p>
                <span>管理员名称 :&nbsp;<?= Html::encode($admin['username']) ?></span>&nbsp;&nbsp;<br/>
		<span>可分配的角色  :<br/> &nbsp;
                    <?php foreach($role as $key => $val){?>
                        <?php if($val['is_checked'] == 1){?>
			    <li style="display:block;float:left;width:140px;height:25px;"><?= Html::checkbox('role_id[]', 'checked',['class' => "che".$val['role_id'],'value' => $val['role_id']]) ?>&nbsp;&nbsp;&nbsp;<?= Html::encode($val['role_name']) ?></li>
                        <?php }else{ ?>
			    <li style="display:block;float:left;width:140px;height:25px;"><?= Html::checkbox('role_id[]', null,['class' => "che".$val['role_id'],'value' => $val['role_id']]) ?>&nbsp;&nbsp;&nbsp;<?= Html::encode($val['role_name']) ?></li>
			<?php }?>
                    <?php }?>
                </span>&nbsp;&nbsp;<br/>
                <?= Html::submitButton('添加', ['class' => 'btn btn-success','id'=>'category-create-btn']) ?>
		<hr/>
	
<p></p>
	<hr/>
	
	
	
  </div>
</div>
</table>
<?php ActiveForm::end(); ?>