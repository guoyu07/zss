<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮播图添加</title>
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
<body>
<div class="widget-title" style="margin-top: 10px;padding-top:7px;"> <span class="icon"><i class="icon-th"></i></span>
            <h5>轮播组添加</h5>
          </div>
<div id='form'>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($group, 'group_name',['inputOptions'=>['placeholder'=>'请输入轮播组名称']])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <?= $form->field($group, 'group_ctime',['inputOptions'=>['placeholder'=>'请输入轮播速度(秒)']])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;']) ?>
    <?php $group->group_show=1; echo $form->field($group, 'group_show')->radioList(['1'=>'显示','0'=>'不显示']) ?><span style="color:red">注:如果选择显示,就会直接显示这组轮播图</span>
    <?= $form->field($group, 'group_start',['inputOptions'=>['placeholder'=>'请输入轮播组开始时间']])->textInput(['class' => 'form-control timepiker','style' => 'width:200px;height:30px;','id'=>'start']) ?>
    <?= $form->field($group, 'group_end',['inputOptions'=>['placeholder'=>'请输入轮播组结束时间']])->textInput(['class' => 'form-control timepiker','style' => 'width:200px;height:30px;','id'=>'end']) ?>
    <span style="color:red"><?php if(isset($mess)){ echo $mess;}?></span>
    <div class="form-group">
        <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
<script src="<?php echo yii::$app->request->baseUrl;?>/js/jquery.min.js"></script>
<script src="<?php echo yii::$app->request->baseUrl;?>/js/jquery.datetimepicker.js"></script>
<script>
$('.timepiker').datetimepicker({
	value:nowdate(),
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


/*
获取当前时间
*/
function nowdate(){
	var d = new Date()
	var vYear = d.getFullYear()
	var vMon = d.getMonth() + 1
	var vDay = d.getDate()
	var h = d.getHours(); 
	var m = d.getMinutes(); 
	s=vYear+'/'+(vMon<10 ? "0" + vMon : vMon)+'/'+(vDay<10 ? "0"+ vDay : vDay)+'  '+(h<10 ? "0"+ h : h)+':'+(m<10 ? "0" + m : m);
	return s;
}
</script>
</div>
</body>
</html>