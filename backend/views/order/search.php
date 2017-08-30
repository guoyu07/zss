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
label{ display:none;}
</style>
<table class="table table-bordered data-table" style="overflow:scroll; font-size:12px;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>订单号码</th>
				  <th>收货人姓名</th>
				   <th>电话</th>
				   <th>派送类型</th>
                  <th>座位号</th>
                  <th>金额</th>			  
				  <th>订单状态</th>
				  <th>支付方式</th>
				  <th>取餐号</th>
				  <th>创建时间</th>
                  <th>修改时间</th>
				  <th>操作</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($models as $model): ?>
                <tr class="gradeX">
                  <td><?= Html::encode($model['order_id']) ?></td>
                  <td><a href="javascript:void(0)"><?= Html::encode($model['order_sn']) ?></a></td>
				  <td><?= Html::encode($model['user_name']) ?></td>
				    <td><?= Html::encode($model['user_phone']) ?></td>
					<td>
						<?php if($model['delivery_type']==1){ echo "堂食"; }elseif($model['delivery_type']==2){ echo "自取"; }elseif($model['delivery_type']==3){ echo "外卖"; } ?>
					</td>
                  <td><?php if(Html::encode($model['seat_number'])){ echo Html::encode($model['seat_number']); }else{ echo "—"; } ?></td>
                   <td>￥<?= Html::encode($model['order_total']) ?></td> 				 
				   <td>
						<?php 
						if(Html::encode($model['order_status'])==0)
						{
							echo "未支付"; 
						}
						elseif(Html::encode($model['order_status'])==1)
						{ 
							echo "已付款"; 
						}elseif(Html::encode($model['order_status'])==2)
						{ 
							echo "订单关闭"; 
						}elseif(Html::encode($model['order_status'])==3)
						{ 
							echo "成功"; 
						} 
				   ?>
				   </td>
				   <td>
				    <?php if(Html::encode($model['payonoff'])=='online'){ echo "线上支付"; }elseif(Html::encode($model['payonoff'])=='balance'){ echo "余额支付"; } ?>
				   </td>

				   <td><?php if(Html::encode($model['meal_number'])){ echo Html::encode($model['meal_number']); }else{ echo "—"; } ?></td>
				   <td><?= Html::encode(date('Y-m-d H:i',$model['created_at'])) ?></td>
                    <td><?= Html::encode(date('Y-m-d H:i',$model['updated_at'])) ?></td>
					<td><img id="see" value="<?= Html::encode($model['order_id']) ?>" alt="查看" style="cursor:pointer;" src="./assets/order/search.png" title="查看" width=20 height=20 onclick="showdiv(<?= Html::encode($model['order_id']) ?>);"></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>