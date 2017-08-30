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
label{ 
	display:none;
}

</style>
	<div>
          <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>满减详细信息</h5><input style="float:right; padding:2px 10px;" id="btnclose" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
          </div>
          
	<div  style="float:left;margin-left:150px;margin-top:20px">
		<button class="btn btn-inverse btn-mini" style="width:85px">ID </button>：</span><?php echo $model['subtract_id']?></span><br><br>
		<button class="btn btn-inverse btn-mini" style="width:85px">满 </button>：</span><?php echo $model['subtract_price']?></span><br>
		<button class="btn btn-inverse btn-mini" style="width:85px">减 </button>：</span><?php echo $model['subtract_subtract']?></span><br>
		<button class="btn btn-inverse btn-mini" style="width:85px">是否显示 </button>：</span><?php echo $model['subtract_show']?></span><br>
		<button class="btn btn-inverse btn-mini" style="width:85px">修改人 </button>：</span><?php echo $model['username']?></span><br>
		<button class="btn btn-inverse btn-mini" style="width:85px">创建时间 </button>：</span><?php echo $model['created_at']?></span><br>
		<button class="btn btn-inverse btn-mini" style="width:85px">修改时间 </button>：</span><?php echo $model['updated_at']?></span><br>		 </div>
		<div style="clear:both"></div>
		<br><br><br><br><br>
		<hr/>

</div>

