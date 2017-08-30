<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '红包管理';
?>	
		<?php	foreach ($wallet as $model):?>
				
                <tr class="gradeX" id="hang_<?= Html::encode($model['wallet_id'])?>">
                  <td class="id_<?= Html::encode($model['wallet_id'])?>">
				  <input type="checkbox" class="choall"  value="<?=Html::encode($model["wallet_id"])?>" name="checkbox">
				  </td>
				  <td>
				  <?= Html::encode($model['wallet_id'])?>
				  </td>
                  <td class="name_<?= Html::encode($model['wallet_id'])?>">
				  <?= Html::encode($model['wallet_name'])?>
				  </td>
				  <td class="all_<?= Html::encode($model['wallet_id'])?>">
				  <?= Html::encode($model['wallet_price'])?>
				  </td>
                  <td class="status_<?= Html::encode($model['wallet_id'])?>">
				  <?php if(Html::encode($model['wallet_is_price'])==1){
							echo "是";
						} else {
							echo "否";
						}
						?>
				  </td>
                  <td class="share_<?= Html::encode($model['wallet_id'])?>">
				  <?= Html::encode($model['wallet_share_price'])?>
				  </td>
                  <td class="shares_<?= Html::encode($model['wallet_id'])?>">
				  <?= Html::encode($model['wallet_shares_price'])?>
				  </td>
				  <td class="show_<?= Html::encode($model['wallet_id'])?>" id="changeShow" name="<?= Html::encode($model['wallet_id'])?>"value="<?= Html::encode($model['wallet_show'])?>">
				<?php if(Html::encode($model['wallet_show'])== 1 ){
					echo "<img src='assets/ico/ico/34.ico' style='width:20px;height:20px;cursor:pointer;'>";
				  } else{
					echo "<img src='assets/ico/ico/40.ico' style='width:20px;height:20px;cursor:pointer;'>";
				  }?>
				  </td>
				  <td><?= Html::encode($model['username'])?></td>
				  <td>
				  <img src="assets/img/search.png" id="moreinfo_<?= Html::encode($model['wallet_id'])?>" style="cursor:pointer;width:20px;height:20px" onclick="getmoreinfo(<?= Html::encode($model['wallet_id'])?>)"/> 
				  <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/upd_wallet','id'=>Html::encode($model['wallet_id'])])?>">
				  <img src="assets/img/edit.png" id="updatewallet" value="<?= Html::encode($model['wallet_id'])?>" 
				  style="cursor:pointer;"/> 		
				  </a>
				  <img src="assets/img/delete.png" id="delwallet" value="<?= Html::encode($model['wallet_id'])?>" style="cursor:pointer;"/>
				  </td>
                </tr> 
				<?php endforeach;?>