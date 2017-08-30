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
<form method='post' action='index.php?r=user/updmember'> 
<table border=1>
			<div class="widget-box">
          <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>管理员详细信息</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
          </div>
          <div class="widget-content">
            <h5 id='order_sn'>详细信息&nbsp;</h5>
            <p>
               <button class="btn btn-inverse btn-mini">会员信息</button>
			  <button class="btn btn-inverse btn-mini">
					<span></span>&nbsp;&nbsp;|
					<span>ID :&nbsp;&nbsp;<?= Html::encode($result['user_id']); ?></span>&nbsp;&nbsp;|
					<span>名称 :&nbsp;&nbsp;<?= Html::encode($result['uname']); ?></span>&nbsp;&nbsp;|
					<span>性别 :&nbsp;&nbsp;<?= Html::encode($result['user_sex']); ?></span>&nbsp;&nbsp;|
					<span>余额 :&nbsp;&nbsp;<?= Html::encode($result['user_price']); ?></span>&nbsp;&nbsp;|
					<span>积分 :&nbsp;&nbsp;<?= Html::encode($result['user_virtual']); ?></span>&nbsp;&nbsp;|
                                        <?php  if(isset($username)){?>
                                        <span>上次修改人 :&nbsp;&nbsp;<?= Html::encode($username['username']); ?></span>&nbsp;&nbsp;|                                      <?php }?>
			  </button>
		  </p>
                  
                      <input type='hidden' name='cid' value="<?= Html::encode($result['user_id'])?>"/>
                      <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken() ?>" />
                  <span>积分调整:<input type='text' name='virtual' style='width:50px;'></span><br/>
                  <span>余额调整:<input type='text' name='price'  style='width:50px;'></span><br/>
                  <span><input type='submit' value='修改' class='btn btn-success' />   <input type='button' id='btnclose' value='关闭'  class='btn btn-success'/></span><br/>
                
<p>
<hr/>
	 <p><button class="btn btn-inverse btn-mini">消费记录</button></p>
                <span>订单号 :&nbsp;<?= Html::encode($result['order_sn']); ?></span>&nbsp;&nbsp;<br/>
		<span>菜品名称 :&nbsp;<?= Html::encode($result['menu_name']); ?></span>&nbsp;&nbsp;<br/>
		<span>消费门店 :&nbsp;<?= Html::encode($result['shop_name']); ?></span><br>
                <span>取餐号 :&nbsp;<?= Html::encode($result['meal_number']); ?></span><br>
                <span>消费 :&nbsp;<?= Html::encode($result['order_total']); ?></span><br>
                <span>日期 :&nbsp;<?= Html::encode(date("Y-m-d H:i:s",$result['pay_at'])); ?></span><br>
		<hr/>
	
</p>
	<hr>
	</hr>
	
	
  </div>
</div>
</table>
</form>