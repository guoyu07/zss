<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '提示语'; 
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
            <h5>提示语</h5>
          </div>
		 <!--展开 收起  start -->
		 <!--
		  <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
			<div id="searchdiv">
				 <button class="btn btn-inverse add">添加配送员</button>
				 <button class="btn btn-info" id="del_button">删除</button>
				 <button class="che btn btn-info">全选</button>
				<div id="search">
					<input type="text" placeholder="请输入配送员的名称..." id="word"/>
					<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
				</div>
			</div>
		 -->
		 <!--展开 收起  end -->
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style=" font-size:14px;">
            
			<h1 style="width:100%; text-align:center"><?= $msg ?></h1>
            
            </table>
          </div>
        </div>
<div style="display:none">
    <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体"></table>
</div>
<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
<img id="loading" src="./assets/order/load.gif" style="z-index:20000; background-color:rgba(0,152,50,0.7); display:none; z-index:999; position:fixed; top:55%; margin-top:-100px; left:45%">
<script type="text/javascript">
 $(".che").toggle(
            function () {
              $(".one").attr("checked",true);
            },
            function () {
              $(".one").attr("checked",false);
            }
          );

//loading
function loading(num){
	if(num==1){
		$("#loading").show();
	}else{
		$("#loading").hide();
	}
}

function deletedata(){
	$("input[name=checkdel]:checked").each(function(){
		$(this).parent().parent().parent().parent().remove();
	})
}

$("#small").toggle(function(){
		$("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
		$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
	  },function(){
		$("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
		$("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
 });

$("#all").click(function(){  
        if(this.checked){  
            $("input[type=checkbox]").prop("checked",true);     
        }else{      
            $("input[type=checkbox]").prop("checked",false);   
        }      
});  
</script>