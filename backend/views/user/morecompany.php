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

<table border=1>
            <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>公司详细信息</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
            </div>
            <div class="widget-content">
        <p><button class="btn btn-inverse btn-mini"><h5>ID :<span><?= Html::encode($result['company_id']); ?></span></h5></button></p>
                <span>名称 :&nbsp;<?= Html::encode($result['company_name']); ?></span>&nbsp;&nbsp;<br/>
		<span>折扣 :&nbsp;<?= Html::encode($result['company_discount']); ?></span>&nbsp;&nbsp;<br/>
		<span>满 :&nbsp;<?= Html::encode($result['company_price']); ?></span><br>
                <span>减 :&nbsp;<?= Html::encode($result['company_subtract']); ?></span><br>
                <span>满赠 :&nbsp;<?php if(isset($result['gift_name'])){ echo $result['gift_name']; }?></span><br>
                <span>创建日期 :&nbsp;<?= Html::encode(date("Y-m-d H:i:s",$result['ccreated'])); ?></span><br>
                <span>上次修改日期 :&nbsp;<?= Html::encode(date("Y-m-d H:i:s",$result['cupdated'])); ?></span><br>
                
		<hr/>
	
	</hr>
	
	
         </div>
</div>
</table>