<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '赠品管理';
?>


		<?php	foreach ($model as $v){?>
				
                <tr class="gradeX" id="hang_<?= Html::encode($v['gift_id'])?>">
				  <td>  
				  <input type="checkbox" class="choall"  value="<?=Html::encode($v["gift_id"])?>" name="checkbox">
				  </td>
				  <td><?= Html::encode($v['gift_id'])?></td>
				  <td><?=Html::encode($v["gift_name"])?></td>
				  <td><?=Html::encode($v["gift_num"])?></td>
				  <td><?=Html::encode($v["gift_price"])?></td>

				  <td class="show_<?= Html::encode($v['gift_id'])?>" id="changeShow" name="<?= Html::encode($v['gift_id'])?>"value="<?= Html::encode($v['gift_show'])?>">
				<?php if(Html::encode($v['gift_show'])== 1 ){
					echo "<img src='assets/ico/ico/34.ico' style='width:20px;height:20px;cursor:pointer;'>";
				  } else{
					echo "<img src='assets/ico/ico/40.ico' style='width:20px;height:20px;cursor:pointer;'>";
				  }?>
				  </td>
				  <td><?= Html::encode($v['username'])?></td>
				  <td>
				  <img src="assets/img/search.png" id="moreinfo_<?= Html::encode($v['gift_id'])?>" style="cursor:pointer;width:20px;height:20px" onclick="getmoreinfo(<?= Html::encode($v['gift_id'])?>)"/> 
				  <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/updgift','id'=>Html::encode($v['gift_id'])])?>">
				  <img src="assets/img/edit.png" id="updategift" value="<?= Html::encode($v['gift_id'])?>" 
				  style="cursor:pointer;"/> 		
				  </a>
				  <img src="assets/img/delete.png" id="delwallet" value="<?= Html::encode($v['gift_id'])?>" style="cursor:pointer;"/>	
				  </td>
                </tr> 
				<?php };?>
