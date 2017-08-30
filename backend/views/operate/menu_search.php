<?php
use yii\helpers\Html;
?>
<style>
	label{display:none}
</style>
<script src="<?php yii::$app->request->baseUrl?>js/matrix.tables.js"></script>
<table class="table table-bordered data-table">
	<div style="display:none;" id="excel"><?= Html::encode(json_encode($stat_menu)) ?></div>
	<div style="display:none;" id="line"><?= Html::encode($menu_info) ?></div>
	<div style="display:none;" id="date"><?= Html::encode($time) ?></div>
	<thead>
		<tr>
			<th class="sort">ID&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">菜品名称&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">厨师名称&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">菜品单价&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">菜品销量&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">菜品销量总额&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">统计时间&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
			<th class="sort">操作&nbsp;&nbsp;<span class="icon-caret-up"></span></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($stat_menu as $key => $model) : ?>
		<tr class="gradeX">
			<td class="center"><?= $key+1 ?></td>
			<td class="center"><?= Html::encode($model['menu_name']) ?></td>
			<td class="center"><?= Html::encode($model['series_name']) ?></td>
			<td class="center">￥<?= Html::encode($model['menu_price']) ?></td>
			<td class="center"><?= Html::encode($model['menu_count']) ?>份</td>
			<td class="center">￥<?= Html::encode($model['menu_total']) ?></td>
			<td class="center"><?= Html::encode($model['created_at']) ?></td>
			<td class="center">
				<a href="<?php echo \Yii::$app->urlManager->createUrl(['operate/menu-detail']) ?>&menu_name=<?= $model['menu_name'] ?>&date=<?= $model['created_at'] ?>">
				<img id="see" width="20" height="20" title="菜品信息查看" src="./assets/order/search.png" style="cursor:pointer;" alt="菜品信息查看">
				</a>
			</td>
		</tr>
		<?php endforeach ; ?>
	</tbody>
</table>
