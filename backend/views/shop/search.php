<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<style type="text/css">
label{display:none}
</style>
<table class="table table-bordered data-table" style=" font-size:14px;">
              <thead>
                <tr>
				  <th><input type="checkbox" id="all"></th>
                  <th>ID</th>
                  <th>门店名称</th>
                  <th>营业状态</th>
				  <th style="width:100px;">门店地址</th> 
				  <th>门店电话</th>
				  <th>经度</th>
				  <th>纬度</th>
				  <th>修改人</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
				<?php foreach($models as $k=>$model): ?>
                <tr class="gradeX">
				  <td><input type="checkbox" name="checkdel" value="<?= $model['shop_id']; ?>"></td>
                  <td><?= Html::encode($model['shop_id']); ?></td>
                  <td><?= Html::encode($model['shop_name']); ?></td>
                  <td style="width:5%">
					<?php if(Html::encode($model['shop_status'])==1): ?>
						<img id="status" class="<?= $model['shop_id']; ?>" value="1" src="./assets/ico/png/34.png">
					<?php else: ?>
						<img id="status" class="<?= $model['shop_id']; ?>" value="0"  src="./assets/ico/png/40.png">
					<?php endif; ?>
				  </td>
				  <td style="width:20%;"><?= Html::encode($model['shop_address']); ?></td>
				  <td><?= Html::encode($model['shop_tel']); ?></td>
				   <td><?= Html::encode($model['shop_x']); ?></td>
				    <td><?= Html::encode($model['shop_y']); ?></td>
				  <td><?= Html::encode($model['username']); ?></td>
                  <td id="act" style="width:10%">
					<img value="<?= Html::encode($model['shop_id']); ?>" onclick="showdiv(<?= Html::encode($model['shop_id']); ?>);" src="./assets/order/edit.png" alt="编辑" title="编辑"/>
					<img value="<?= Html::encode($model['shop_id']); ?>" id="delete" class="del<?= Html::encode($model['shop_id']); ?>" src="./assets/order/delete.png" alt="删除" title="删除"/>
					<img width=20 height=20 value="<?= Html::encode($model['shop_id']); ?>" id="shop" src="./assets/order/search.png" alt="门店信息查看" title="门店信息查看"/>
				  </td>
                </tr>   
				<?php endforeach; ?>
              </tbody>
            </table>

<script type="text/javascript">

</script>