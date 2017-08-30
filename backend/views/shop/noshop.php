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
            <h5>门店列表</h5>
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
            <table class="table table-bordered data-table" style=" font-size:14px;">
            <thead>
                <tr>
				  <th><input type="checkbox"></th>
                  <th>ID</th>
                  <th>门店名称</th>
                  <th>营业状态</th>
				  <th>门店地址</th>
				  <th>门店电话</th>
				  <th>经度</th>
				  <th>纬度</th>
                  <th>操作</th>
                </tr>
             </thead>
            </table>
          </div>
        </div>
<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
<img id="loading" src="./assets/order/load.gif" style="z-index:20000; background-color:rgba(0,152,50,0.7); display:none; z-index:999; position:fixed; top:55%; margin-top:-100px; left:45%">
