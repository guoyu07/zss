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
	background-color:#F8F8F8;
    }
    #form{
     margin-left:100px;
     float:left;
    position:absolute;
    left:400px;
    margin-top:20px;
    }
    #editor{
	  float:left;
      position:absolute;
      left:100px;
      top:100px;
    }
</style>
    <script type="text/javascript" charset="utf-8" src="<?php yii::$app->request->baseUrl;?>ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php yii::$app->request->baseUrl;?>ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="<?php yii::$app->request->baseUrl;?>ueditor/lang/zh-cn/zh-cn.js"></script>
<body>
<div class="widget-title" style="margin-top: 10px;padding-top:7px;"> <span class="icon"><i class="icon-th"></i></span>
            <h5>轮播图添加</h5>
          </div>
 <div id='editor' style="width:300px;height:500px;"><img src="<?php yii::$app->request->baseUrl;?>images/food.jpg"></div>

<div id='form'>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-danger">
    <?=Yii::$app->session->getFlash('success')?>
    </div>
<?php endif ?>
<?php $form=ActiveForm::begin([
    'id'=>'upload',
    'enableAjaxValidation' => false,
    'options'=>['enctype'=>'multipart/form-data']
]);
?>
<?= $form->field($carousel, 'carousel_title',['inputOptions'=>['placeholder'=>'请输入轮播图名称']])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;'])  ?>
<?= $form->field($carousel, 'carousel_desc')->textArea(['rows' => '6','style'=>'width:400px;']) ?>
<?php if($group){?>
<select name='group' style='width:200px;'>
<?php foreach ($group as $gk=>$gv):?>
<option value="<?php echo $gv['group_id']?>" ><?php echo $gv['group_name'];?></option>
<?php endforeach;?>
</select>
<?php }else{
    echo "<font color='red'>请先添加轮播组</font>";
}?>
<?= $form->field($upload, 'file')->fileInput();?>
<?=  Html::submitButton('提交', ['class'=>'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
 </div>
 
</body>
</html>