<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<style>
label{display:none}
</style>
                <table class="table table-bordered data-table">
              <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                  <th>名称</th>
                  <th>创建时间</th>
                  <th>修改时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach($partner as $models){  ?>
                    <tr class="gradeX">
                      <td><input type="checkbox" class='one' value='<?= Html::encode($models['company_id']) ?>'></td>
                      <td><?= Html::encode($models['company_id']);?></td>
                      <td><?= Html::encode($models['company_name']);?></td>
                      <td><?= Html::encode(date("Y-m-d H:i:s",$models['created_at']));?></td>
                      <td class="center"><?= Html::encode(date("Y-m-d H:i:s",$models['updated_at']));?></td>
                      <td><a   href="javascript:void(0)" class="upd" id="d<?= Html::encode($models['company_id']);?>" value="<?= Html::encode($models['company_id']);?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/actions/edit.png"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="javascript:void(0)" class="del" id="d<?= Html::encode($models['company_id']);?>" value="<?= Html::encode($models['company_id']);?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/actions/delete.png"/></a></td>
                    </tr>
                  <?php };?>
              </tbody>
            </table>