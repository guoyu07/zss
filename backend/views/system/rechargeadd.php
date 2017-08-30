<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '充值奖励添加';
?>
<style>
*{margin:0 auto;}
body{
	margin-top:1px;
	background-color:#fff;
}
</style>
<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>充值奖励添加</h5>
</div>
<div style="position:absolute;left:50px;top:100px;">
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($recharge, 'rebate_price',['inputOptions'=>['placeholder'=>'请输入充值金额']])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <?= $form->field($recharge, 'rebate_send',['inputOptions'=>['placeholder'=>'请输入奖励金额']])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <font color='red'><?= Html::encode($mess);?></font>
        <div class="form-group">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div> 


<script>
$("form").submit(function(){
	recharge_price = $("#recharge-recharge_price").attr("value");	 
	recharge_add = $("#recharge-recharge_add").attr("value");	 
	if(recharge_price == ""){
		alert("不能为空");
		return false;	 
	}else if(recharge_add == ''){
		alert("不能为空");
		return false;	
	}else{
		return true;
	}
	
});
</script>


