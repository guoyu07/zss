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
            <h5>管理员详细信息</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
          </div>
          <div class="widget-content">
    
              <p></p>
<hr/>
                <p><button class="btn btn-inverse btn-mini"></button></p>
                <span>用户名 :&nbsp;<?= Html::encode($admin['username']) ?></span>&nbsp;&nbsp;<br/>
		<span>当前角色 :&nbsp;<?php foreach($role as $key => $val){?>
								<?php if($val['is_checked'] == 1){?>
									<?= Html::encode($val['role_remark']) ?>
								<?php } ?>
							<?php }?>
                </span>&nbsp;&nbsp;<br/>
		<span>Email :&nbsp;<?= Html::encode($admin['email']) ?></span><br>
                <span>注册时间 :&nbsp;<?= date("Y-m-d H:i:s") ?></span><br>
                <span>最近登录时间/IP :&nbsp;<?php echo date("Y-m-d H:i:s",$admin['created_at']); ?>/
							<?= Html::encode($admin['login_ip']) ?></span><br>
                <span>修改时间 :&nbsp;<?php echo date("Y-m-d H:i:s",$admin['updated_at']); ?></span><br />
		<hr/>
	
<p></p>
	<hr/>
	
	
	
  </div>
</div>
</table>
