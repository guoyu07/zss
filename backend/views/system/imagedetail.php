<?php
use yii\helpers\Html;
$this->title = '轮播图详情';
?>

<style>
*{
	margin:0 auto;
}
label{ display:none;}
    #detailall{
    	width:1000px;
    	font-family:"楷体";
    	font-size:20px;
    	line-height:20px;
    	margin-left:-20px;
    }
    
    textarea{
	   font-family:"楷体";
    	font-size:18px;
    	border:none;
    	line-height:22px;
    	background-color:#eee;
    }
    
    .detailrow{
    	width:800px;
    	height:30px;
    	margin:10px 0 10px 200px;
    }
    .button{
    	width:200px;
    	height:20px;
    	margin-right:10px;
    	float:left;
    }
    .detailval{
    	height:30px;
    	width:580px;
    	float:left;
    	color:#666;
    	line-height:50px;
    }
     button{
	   float:left;
    	background-color:#5783DC;
    	color:white;
     	margin-top:15px;
     	margin-left:20px;
    }
    .btn-primary{ width:150px;margin-right:20px;}
</style>
<div style="margin-left:100px;margin-top:30px;">
	<h4>轮播图详情</h4>
</div>
<div id="detailall">
<div class="detailrow">
	<div class="button"><button class="btn btn-primary" disabled>轮播图名称</button></div>
	<div class="detailval"><?= Html::encode($imagedetail['carousel_title']);?></div>
</div>
<div class="detailrow">
	<div class="button"><button class="btn btn-primary" disabled>轮播图所属分类</button></div>
	<div class="detailval"><?= Html::encode($imagedetail['group_name']);?></div>
</div>
<div class="detailrow" >
	<div class="button" ><button class="btn btn-primary" disabled>轮播图描述</button></div>
	<div class="detailval"><textarea rows="2" cols="50" disabled><?= Html::encode($imagedetail['carousel_desc']);?></textarea></div>
</div>
<div class="detailrow">
	<div class="button"><button class="btn btn-primary" disabled>创建时间</button></div>
	<div class="detailval"><?= Html::encode(date('Y-m-d H:i:s',$imagedetail['created_at']));?></div>
</div>
<div class="detailrow">
	<div class="button"><button class="btn btn-primary" disabled>上次修改时间</button></div>
	<div class="detailval"><?= Html::encode(date('Y-m-d H:i:s',$imagedetail['updated_at']));?></div>
</div>
<div class="detailrow">
	<div class="button"><button class="btn btn-primary" disabled>上次修改人</button></div>
	<div class="detailval"><?= Html::encode($imagedetail['username']);?></div>
</div>
<div class="detailrow">
	<div class="button"><button class="btn btn-primary" disabled>轮播图展示</button></div>
	<div class="detailval"><img src=<?php yii::$app->request->baseUrl;?><?= Html::encode($imagedetail['carousel_original']);?>></div>
</div>
</div>
<script type="text/javascript">
    function goBack()
    {
    window.history.back()
    }
</script>