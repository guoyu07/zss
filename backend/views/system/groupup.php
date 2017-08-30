<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮播组修改</title>
</head>
<style>
    body{
	background-color:#fff;
    }
    #form{
	 margin-top:10px;  
     margin-left:100px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo yii::$app->request->baseUrl;?>/css/jquery.datetimepicker.css"/>
<script src="<?php echo yii::$app->request->baseUrl;?>/js/jquery-1.12.2.min.js"></script>
<body>
<div class="widget-title" style="margin-top: 10px;"> <span class="icon"><i class="icon-th"></i></span>
            <h5>轮播组修改</h5>
          </div>
<div id='form'>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($group, 'group_id')->hiddenInput(['value'=>$gdata['group_id']]) ?>
    <?= $form->field($group, 'group_name',['inputOptions'=>['value'=>$gdata['group_name']]])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <?= $form->field($group, 'group_ctime',['inputOptions'=>['value'=>$gdata['group_ctime']]])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <?php if($gdata['group_show'] == 1){echo "是否显示<br/><font color='red'>显示(轮播组启用状态不可修改)</font><br/>";}else{$group->group_show=$gdata['group_show']; echo $form->field($group, 'group_show')->radioList(['1'=>'显示','0'=>'不显示']);}?>
    <?= $form->field($group, 'group_start',['inputOptions'=>['value'=>date('Y/m/d H:i:s',$gdata['group_start'])]])->textInput(['class' => 'form-control timepiker','style' => 'width:200px;height:30px;','id'=>'start']) ?>
    <?= $form->field($group, 'group_end',['inputOptions'=>['value'=>date('Y/m/d H:i:s',$gdata['group_end'])]])->textInput(['class' => 'form-control timepiker','style' => 'width:200px;height:30px;','id'=>'end']) ?>
    <span style="color:red"><?php if(!empty($mess)){echo $mess;}?></span>
    <div class="form-group">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
<script src="<?php echo yii::$app->request->baseUrl;?>/js/jquery.datetimepicker.js"></script>
<script>
$(".radioid").hide();
$('.timepiker').datetimepicker({
	step:20,
    inputMask: true});
$('#end').blur(function(){
	var start = $('#start').val();
	var end = $('#end').val();
	var timestart = Date.parse(new Date(start));
	var timeend = Date.parse(new Date(end));
	if(timestart > timeend){
			alert('结束时间不能晚于开始时间');
			return false;
	}
});

</script>
</div>
</body>
</html>