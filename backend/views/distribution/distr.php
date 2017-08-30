<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '门店列表'; 
?>
<style type="text/css">
body{#f9f9f9}
#act img{ cursor:pointer; }
.but{	padding:7px;}
.but  button{ margin-left:15px }
#status{ width:20px; height:20px; cursor:pointer;}
</style>

<?= Html::jsFile('./assets/order/layer/layer.js')?>
<?= Html::cssFile('./assets/order/lab.css')?>
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>门店配送员</h5>
          </div>
		 <!--展开 收起  start -->
		 <!--
		 <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
			<div id="searchdiv">
				<div id="search">
					<input type="text" placeholder="请输入门店名称或地址..." id="word"/>
					<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
				</div>
			</div>
		 -->
		 <!--展开 收起  end -->
          <div class="widget-content nopadding">

			<form action="<?= Url::to(['distribution/add']) ?>" method="POST">
			<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <table class="table table-bordered data-table" style=" font-size:14px;">
            <thead>
                <tr>
                  <th>门店ID</th>
                  <th>配送员</th>
                  <th>操作</th>
                </tr>
             </thead>
              <tbody>
                <tr class="gradeX">
					<td><?= $id ?><input type="hidden" name="id" value="<?= $id ?>"></td>
					<td>
						<?php foreach($all_deli as $key=>$value): ?>
							<?php if(in_array($value['id'], $in_deli)): ?>
								<input type="checkbox" checked name="form[]" value="<?= $value['id']; ?>"><?= $value['username']; ?>
							<?php else: ?>
								<input type="checkbox" name="form[]" value="<?= $value['id']; ?>"><?= $value['username']; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</td>
					<td><input type="submit" value="修改"></td>
                </tr>   
              </tbody>
            </table>
			</form>

          </div>
        </div>

