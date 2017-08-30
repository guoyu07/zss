<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮播图修改</title>
</head>
<style>
    body{
	background-color:#F8F8F8;
    }
    #form{
	 margin-top:10px;  
     margin-left:100px;
     float:left;
    }
    
    #editor{
	  float:left;
      position:absolute;
      right:300px;
    
    }
</style>
    <script type="text/javascript" charset="utf-8" src="<?php yii::$app->request->baseUrl;?>ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php yii::$app->request->baseUrl;?>ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="<?php yii::$app->request->baseUrl;?>ueditor/lang/zh-cn/zh-cn.js"></script>
<body>
<div class="widget-title" style="margin-top: 10px;padding-top:7px;"> <span class="icon"><i class="icon-th"></i></span>
            <h5>轮播图修改</h5>
          </div>
<div id='form'>
<?php $form=ActiveForm::begin([
    'id'=>'upload',
    'enableAjaxValidation' => false,
    'options'=>['enctype'=>'multipart/form-data']
]);
?>
<?= $form->field($carousel, 'carousel_title',['inputOptions'=>['value'=>$result['carousel_title']]])->textInput(['class' => 'form-control','style' => 'width:200px;height:30px;'])  ?>
<?= $form->field($carousel, 'carousel_desc',['inputOptions'=>['value'=>$result['carousel_desc']]])->textArea(['rows' => '6','style'=>'width:400px;']) ?>
<select name='group' style='width:200px;'>
<?php foreach ($group as $gk=>$gv):?>
<option value="<?php echo $gv['group_id']?>" ><?php echo $gv['group_name'];?></option>
<?php endforeach;?>
</select>
<input type='hidden' value="<?php echo $result['carousel_pc'];?>" name="hidden_img"/>
<br/>
原图:<br/> 
<img alt="原图" src="<?php yii::$app->request->baseUrl?><?php echo $result['carousel_pc']?>" width="300" height="100">
<?= $form->field($upload, 'file')->fileInput();?>
<?=  Html::submitButton('修改', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>

<?php ActiveForm::end(); ?>
</div>
 <div id='editor' style="width:300px;height:500px;"><img src="<?php yii::$app->request->baseUrl;?>images/food.jpg"></div>

</body>
</html>