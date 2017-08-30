<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
$this->title = '门店团餐';
?>
<?= Html::jsFile('./assets/order/laydate/laydate.js')?>
<?= Html::cssFile('./assets/order/lab.css')?>
<?= Html::cssFile('./assets/order/xia.css')?>
<?= Html::jsFile('./assets/order/layer.js')?> 

<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>选择门店团餐</h5>
          </div>

          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:12px;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>门店名称</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody>
			  <?php if(isset($allinfo)): ?>
			  <?php foreach($allinfo as $model): ?>
                <tr class="gradeX">
					<td><?= Html::encode($model['shop_id']) ?></td>
					<td><?= Html::encode($model['shop_name']) ?></td>
					<td><a href="<?= Url::to(['shop/shopmeal'])."&shop_id=".$model['shop_id']; ?>"><button class="btn btn-inverse">团购点餐</button></a></td>
                </tr>
              <?php endforeach; ?>
			  <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>