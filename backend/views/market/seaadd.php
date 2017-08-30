<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '满赠管理';
?>


<?php foreach($models as $model):?>
                <tr class="gradeX" id="hang_<?= Html::encode($model['add_id'])?>">
				  <td>
				  <input type="checkbox" class="choall"  value="<?=Html::encode($model["add_id"])?>" name="checkbox">
				  </td>
				  <td>
				  <?= Html::encode($model['add_id'])?>
				  </td>
                  <td><?= Html::encode($model['add_price'])?></td>
                  <td><?= Html::encode($model['gift_name'])?></td>
				  <td class="show_<?= Html::encode($model['add_id'])?>" id="changeShow" value="<?= Html::encode($model['add_show'])?>" name="<?= Html::encode($model['add_id'])?>">
				  <?php if($model['add_show']==1){
							echo "<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>";
							}else{
							echo "<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>";		
						}?>
				  </td>
				   <td><?= Html::encode($model['username'])?></td>
				  <td>
				  <img src="assets/img/search.png" id="moreinfo_<?= Html::encode($model['add_id'])?>" style="cursor:pointer;width:20px;height:20px" onclick="getmoreinfo(<?= Html::encode($model['add_id'])?>)"/> 
				  <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/upd_add','id'=>Html::encode($model['add_id'])])?>">
				  <img src="assets/img/edit.png" class="upd_add" name="<?= Html::encode($model['add_id'])?>" style="cursor:pointer;"/>
					</a>
				  <img src="assets/img/delete.png" class="del_add" name="<?= Html::encode($model['add_id'])?>" style="cursor:pointer;"/>
				  </td>
                </tr>    
				<?php endforeach;?>
