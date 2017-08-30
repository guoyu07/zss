 <?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '门店列表'; 
?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<!--百度地图产品密钥-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=qsBc7zj8VnjrxUauu2xgwGeX"></script>
<style type="text/css">
body{ font-size:15px; background-color:#f9f9f9;}
.control-label{ font-size:16px; font-family: 微软雅黑}
#left{ float:left; border:0px red solid; width:40%; }
#right{  float:left; border:0px red solid;  }
.btn-primary{ width:110px;}
.status{cursor:pointer;}
#allmap {width:100%; height:40%;}
</style>

  <div class="widget-box" style="overflow:scroll; font-size:15px;font-family:楷体">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>菜品详情</h5>
        </div>

        <div class="widget-content nopadding" >
          <form action="#" method="get" class="form-horizontal">

		  <div class="control-group">
              <label class="control-label">
					<button style="width:300px; margin-left:50px;" class="btn btn-primary" disabled>
					菜品&nbsp;名称:&nbsp;
					<span id="shop_id"><?= $allinfo["name"]?></span>
					
					</button>
			 </label>
              <div class="controls" style="font-size:20px; padding-top:15px;">
              </div>
            </div>
			
<!--left start -->
<div id="left">

	<div class="control-group" style="">
	  <label class="control-label"><button class="btn btn-primary" disabled>所属类别</button></label>
	  <div class="controls" style=" padding-top:20px;">
	  <?= $allinfo["series_name"]?>
	  </div>
	</div>
	  <div class="control-group">
		  <label class="control-label"><button class="btn btn-primary" disabled>单位</button></label>
		  <div class="controls"  style=" padding-top:15px;">
			<?= $allinfo["menu_code"]?>
		  </div>
		</div>
	 <div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>价格</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= $allinfo["price"]?>
	  </div>
	</div>
	 <div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>添加时间</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= $allinfo["addtime"]?>
	  </div>
	</div>
	 <div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>排序</button></label>
	  <div class="controls"  style=" padding-top:20px;">
	<?= $allinfo["sort"]?>
	  </div>
	</div>
	 

</div>


<!--left end -->
<!--right start -->
<div id="right">

  <div class="control-group">
	  <label class="control-label"><button class="btn btn-primary" disabled>图片</button></label>
	  <div class="controls"  style=" padding-top:20px;">
		<?= $allinfo["img"]?>
	  </div>
	</div>
	 <div class="control-group">
		  <label class="control-label"><button class="btn btn-primary" disabled>菜品描述</button></label>
		  <div class="controls"  style=" padding-top:20px;">
			<?= $allinfo["menuintroduce"]?>
		  </div>
		</div>
	<div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>上一次修改人</button></label>
	  <div class="controls"  style=" padding-top:20px;">
	<?= $allinfo["fixman"]?>
	  </div>
	</div>
	<div class="control-group">
	  <label for="checkboxes" class="control-label"><button class="btn btn-primary" disabled>上次修改时间</button></label>
	  <div class="controls"  style=" padding-top:20px;">
	<?= $allinfo["fixtime"]?>
	  </div>
	</div>
	 <div class="control-group">
	 <br>
			<div id="allmap"></div>
			
	</div>


</div>
<!--right end -->


	  </form>
	</div>
</div>

<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">



	
