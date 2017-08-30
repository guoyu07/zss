<?php
use yii\helpers\Html;
$this->title = '轮播组详情';
?>
<style>
label{ display:none;}
#details{
	font-size:20px;
	line-height:30px;
	height:300px;
	font-family:"楷体";
	margin-left:200px;
	margin-top:50px;
}

#details div{
	width:600px;
	height:70px;
    margin-top:20px;
	height:20px;
	line-height:20px;
}
#details span{
	display:block;
	width:400px;
	height:25px;
	float:right;
}
.btn-primary{
	background-color:#5783DC;
	color:white;
	width:160px;
}
</style>
<h3 style='margin-top:20px;margin-left:50px;'>轮播组详情</h3>
<div id="details">

<div>
<button class="btn btn-primary" disabled>轮播组名称</button><span><?= Html::encode($detail['group_name']);?></span>
</div>
<div>
<button class="btn btn-primary" disabled>轮播速度</button><span><?= Html::encode($detail['group_ctime']);?>秒</span>
</div>
<div>
<button class="btn btn-primary" disabled>轮播组状态</button><span><?php if(Html::encode($detail['group_show'])){?><img class="status" style="cursor:hand" src="<?php yii::$app->request->baseUrl;?>assets/ico/png/34.png" width="20" height="20"/><?php }else{?><img src="<?php yii::$app->request->baseUrl;?>assets/ico/png/40.png"  width="20" height="20"/><?php } ?></span>
</div>
<div>
<button class="btn btn-primary" disabled>开始时间</button><span><?= Html::encode(date('Y-m-d H:i:s',$detail['group_start']));?></span>
</div>
<div>
<button class="btn btn-primary" disabled>结束时间</button><span><?= Html::encode(date('Y-m-d H:i:s',$detail['group_end']));?></span>
</div>
<div>
<button class="btn btn-primary" disabled>创建时间</button><span><?= Html::encode(date('Y-m-d H:i:s',$detail['created_at']));?></span><br/>
</div>
<div>
<button class="btn btn-primary" disabled>上次修改时间</button><span><?= Html::encode(date('Y-m-d H:i:s',$detail['updated_at']));?></span><br/>
</div>
<div>
<button class="btn btn-primary" disabled>上次修改人</button><span><?= Html::encode($detail['username']);?></span>
<div>
</div>