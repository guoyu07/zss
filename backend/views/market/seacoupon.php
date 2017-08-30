<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '优惠券管理';
?>

			  
			  <?php foreach($coupon as $model):?>
                <tr class="gradeX" id="hang_<?= Html::encode($model['coupon_id'])?>">
                  <td>
					<input type="checkbox" class="choall"  value="<?=Html::encode($model["coupon_id"])?>" name="checkbox">
					</td>
					<td>
				  <?= Html::encode($model['coupon_id'])?>
				  </td>
				  <td class="cou_<?= Html::encode($model['coupon_id'])?>"><?= Html::encode($model['coupon_name'])?></td>

                  <td class="price_<?= Html::encode($model['coupon_id'])?>"><?= Html::encode($model['coupon_price'])?></td>
                   <td class="show_<?= Html::encode($model['coupon_id'])?>" id="changeShow" value="<?= Html::encode($model['coupon_show'])?>" name="<?= Html::encode($model['coupon_id'])?>">
					<?php if($model['coupon_show']==1){ 
						echo "<img src='assets/ico/ico/34.ico' style='width:20px;height:20px'>";
						}else{
							echo "<img src='assets/ico/ico/40.ico' style='width:20px;height:20px'>";
						}
					?>
				   </td>
					<td><?= Html::encode($model['username'])?></td>
					<td>
					<img src="assets/img/search.png" style="cursor:pointer;width:20px;height:20px" onclick="getmoreinfo(<?= Html::encode($model['coupon_id'])?>)"/> 
				  <a href="<?php echo  Yii::$app->urlManager->createUrl(['market/upd_coupon','id'=>Html::encode($model['coupon_id'])])?>">
				  <img src="assets/img/edit.png" id="updatecoupon" value="<?= Html::encode($model['coupon_id'])?>" style="cursor:pointer;"/> 
				  </a>
				  <img src="assets/img/delete.png" id="delcoupon" value="<?= Html::encode($model['coupon_id'])?>" style="cursor:pointer;"/>
				  </td>
                </tr>     
				<?php endforeach;?>
