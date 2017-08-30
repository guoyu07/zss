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

    <div class="widget-box">
          <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>订单详细信息</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close"  class="btn btn-inverse btn-mini"/>
          </div>
         <div class="widget-content">
            <h5 id='order_sn'>详细信息&nbsp;</h5>
            <p>
               <button class="btn btn-inverse btn-mini" disabled="disabled">会员信息</button>
			  <button class="btn btn-inverse btn-mini" disabled="disabled">
					<span></span>&nbsp;&nbsp;|
					<span>ID :&nbsp;&nbsp;<?= Html::encode($result['uid']); ?></span>&nbsp;&nbsp;|
					<span>名称 :&nbsp;&nbsp;<?= Html::encode($result['uname']); ?></span>&nbsp;&nbsp;|
					<span>性别 :&nbsp;&nbsp;<?= Html::encode($result['user_sex']); ?></span>&nbsp;&nbsp;|
					<span>余额 :&nbsp;&nbsp;<?= Html::encode($result['user_price']); ?></span>&nbsp;&nbsp;|
					<span>积分 :&nbsp;&nbsp;<?= Html::encode($result['user_virtual']); ?></span>&nbsp;&nbsp;|
                                        <?php  if(isset($username)){?>
                                        <span>上次修改人 :&nbsp;&nbsp;<?= Html::encode($username['username']); ?></span>&nbsp;&nbsp;                                       <?php }?>
			  </button>
		  </p>

                      <input type='hidden' name='cid' value="<?= Html::encode($result['uid'])?>"/>
                      <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken() ?>" />
                  <span>积分调整:&nbsp;&nbsp;&nbsp;<input type='text' name='virtual' style='width:65px;height:30px;'></span><br/>
                  <span>余额调整:&nbsp;&nbsp;&nbsp;<input type='text' name='price'  style='width:65px;height:30px;'></span><br/>
                          <span>公司:&nbsp;&nbsp;&nbsp;<select name="company" style='width:120px;height:30px;'>
                                  <option  value="1">请选择</option>
                                  <?php foreach($company as $ck => $cv){?>
                                    <?php if ($result['company_id'] == $cv['company_id']) { ?>
                                          <option  value="<?= Html::encode($cv['company_id'])?>" selected><?= Html::encode($cv['company_name']); ?></option>
                                    <?php }else{ ?>
                                          <option  value="<?= Html::encode($cv['company_id'])?>" ><?= Html::encode($cv['company_name']); ?></option>
                                    <?php } ?>
                                  <?php }?>
                                  </select>
                          </span><br/>
                  <span><input type='submit' value='修改' class='btn btn-success' />   </span><br/>
                
<p>
	 <p><button class="btn btn-inverse btn-mini"  disabled="disabled">消费记录</button></p>
         <table style="overflow:scroll; font-size:11px;font-family:楷体">
             <th>订单号 </th><th>菜品名称 </th><th>消费门店 </th><th>取餐号 </th><th>消费 </th><th>日期 </th>
             <tr>
                 <td><?= Html::encode($result['order_sn']); ?></td>
                 <td><?= Html::encode($result['menu_name']); ?></td>
                 <td><?= Html::encode($result['shop_name']); ?></td>
                 <td><?= Html::encode($result['meal_number']); ?></td>
                 <td><?= Html::encode($result['order_total']); ?></td>
                 <td><?= Html::encode(date("Y-m-d H:i:s",$result['pay_at'])); ?></td>
             </tr>
         
         </table>
         <p>
              <p><button class="btn btn-inverse btn-mini"  disabled="disabled">充值记录</button></p>
         <table style="overflow:scroll; font-size:11px;font-family:楷体">
             <th>充值金额 </th><th>日期 </th>
             <?php foreach($charge as $kc =>$vc){?>            
             <tr>
                 <td><?= Html::encode($vc['charge_money']); ?></td>
                 <td><?= Html::encode(date("Y-m-d H:i:s",$vc['created_at'])); ?></td>
             </tr>
             <?php }?>
         </table>
             
<hr/>

	<hr/>
        </div>
    </div>
    
</form>