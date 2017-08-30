<?php
use yii\helpers\Html;
?>
<style>

	label{display:none}
</style>
<script src="<?php yii::$app->request->baseUrl?>js/matrix.tables.js"></script>
<table class="table table-bordered data-table">
	<div style="display:none;" id="excel"><?= json_encode($stat_shop) ?></div>
	<div style="display:none;" id="line"><?= Html::encode($shop_info) ?></div>
	<div style="display:none;" id="date"><?= Html::encode($time) ?></div>
  <thead>
		<tr>
			<th class="sort">ID&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">门店&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">门店地址&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">门店电话&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">销售额&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">赠品支出&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">营业额&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">统计时间&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">操作&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
		</tr>
	</thead>
	<tbody id="list">
		<?php foreach($stat_shop as $key => $model) : ?>
		<tr class="gradeX">
			<td class="center"><?= $key+1 ?></td>
			<td class="center"><?= Html::encode($model['shop_name']) ?></td>
			<td class="center"><?= Html::encode($model['shop_address']) ?></td>
			<td class="center"><?= Html::encode($model['shop_tel']) ?></td>
			<td class="center">￥<?= Html::encode($model['shop_sale']) ?></td>
			<td class="center">￥<?= Html::encode($model['shop_expend']) ?></td>
			<td class="center">￥<?= Html::encode($model['shop_turnover']) ?></td>
			<td class="center"><?= Html::encode($model['created_at']) ?></td>
			<td class="center">
				<a href="<?php echo \Yii::$app->urlManager->createUrl(['operate/shop-detail']) ?>&shop_name=<?= $model['shop_name'] ?>&date=<?= $model['created_at'] ?>">
				<img id="see" width="20" height="20" title="门店信息查看" src="./assets/order/search.png" style="cursor:pointer;" alt="门店信息查看">
				</a>
			</td>
		</tr>
		<?php endforeach ; ?>
  </tbody>
</table>
