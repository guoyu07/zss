<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '充值奖励修改';
?>
<style>
*{margin:0 auto;}
body{
	margin-top:1px;
	background-color:#fff;
}
</style>
<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>充值奖励修改</h5>
</div>
<div style="position:absolute;left:50px;top:100px;">
<?php $form = ActiveForm::begin(); ?>
<input type="hidden" value=<?php echo $rechargeedit['rebate_id']?> name="rebate_id"/>
 <?= $form->field($rechargeedit, 'rebate_id',['inputOptions'=>['value'=>$rechargeedit['rebate_id']]])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;','disabled' => true]) ?>
    <?= $form->field($rechargeedit, 'rebate_price',['inputOptions'=>['value'=>$rechargeedit['rebate_price']]])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <?= $form->field($rechargeedit, 'rebate_send',['inputOptions'=>['value'=>$rechargeedit['rebate_send']]])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <font color='red'><?= Html::encode($mess);?></font>
        <div class="form-group">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div> 