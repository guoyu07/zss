<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;

?>
<style type="text/css">
label{ 
	display:none;
}

</style>
<table border=1>
			<div class="widget-box">
          <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>订单详细信息</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
          </div>
          <div class="widget-content">
            <h5 id='order_sn'>订单号&nbsp;<?= Html::encode($list['order']['order_sn']); ?></h5>
			<p>
				<button class="btn btn-inverse btn-mini">用户信息</button>
				<span>收货人姓名 :&nbsp;&nbsp;<?= $list['order']['user_name']; ?></span>
			</p>

            <p>              
			  <button class="btn btn-inverse btn-mini">		
					<span>电话 :&nbsp;&nbsp;<?= Html::encode($list['order']['user_phone']); ?></span>&nbsp;&nbsp;|
					<span>总价格 :&nbsp;&nbsp;<?= Html::encode($list['order']['order_total']); ?></span>&nbsp;&nbsp;|
					<span>实付款 :&nbsp;&nbsp;<?= Html::encode($list['order']['order_payment']); ?></span>&nbsp;&nbsp;|
					<span>付款时间 :&nbsp;&nbsp;<?= Html::encode(date('Y-m-d H:i:s',$list['order']['pay_at'])); ?></span>&nbsp;&nbsp;|
					<span>售出门店 :&nbsp;&nbsp;<?= Html::encode($list['order']['shop_name']); ?></span>
			  </button>
		  </p>
		  <p>			
				<span>创建时间 :&nbsp;&nbsp;<?= Html::encode(date('Y-m-d H:i:s',$list['order']['created_at'])); ?></span>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<span>修改时间 :&nbsp;&nbsp;<?= Html::encode(date('Y-m-d H:i:s',$list['order']['updated_at'])); ?></span>
		  </p>
		  <p>
               <button class="btn btn-inverse btn-mini">门店地址</button><button class="btn btn-inverse btn-mini"><span> :&nbsp;&nbsp;<?= $list['order']['shop_address']; ?></span> </button>				
		  </p>
		  <p>
			<button class="btn btn-inverse btn-mini">送货地址</button><button class="btn btn-inverse btn-mini"><span> :&nbsp;&nbsp;<?= $list['order']['order_address']; ?></span> </button>
		  </p>
<p>
<hr/>
	<?php if(isset($list['info'])): ?>
		<?php foreach($list['info'] as $k=>$v): ?>
			<span>菜品名称 :&nbsp;<?= Html::encode($v['menu_name']); ?></span>&nbsp;&nbsp;|
			<span>价格 :&nbsp;￥<?= Html::encode($v['menu_price']); ?></span>&nbsp;&nbsp;|
			<span>主厨姓名 :&nbsp;<?= Html::encode($v['series_name']); ?></span><br>
			<span>菜品描述 :&nbsp;<?= Html::encode($v['menu_introduce']); ?></span>
			<hr/>
		<?php endforeach; ?>
	<?php endif; ?>
</p>

	<h5>该订单已经使用优惠价</h5>
	<h5>
		<?php
		
			echo "使用了红包&nbsp;".$list['order']['wallet']."<br>";

			echo "满减金额为&nbsp;".$list['order']['sub']."<br>";

			echo "使用优惠券&nbsp;".$list['order']['coupon'];
		?>
	</h5>

</hr>
  </div>
</div>
</table>

