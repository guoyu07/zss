<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
	<!-- 引入红包的文件 -->  
	<?= Html::jsFile('/wallet_template/third-party/jquery.min.js')?>
	<?= Html::jsFile('/wallet_template/umeditor.config.js')?>
	<?= Html::jsFile('/wallet_template/umeditor.min.js')?>
	<?= Html::jsFile('/wallet_template/lang/zh-cn/zh-cn.js')?>

	<?= Html::cssFile('/wallet_template/themes/default/css/umeditor.css')?>
<style type="text/css">
body{ background:#f9f9f9}
</style>
	<div class="widget-box" style=" height:600px; ">
	  
	  
	  <div class="widget-box" style=" height:600px; ">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>修改红包</h5>
        </div>
        <div class="widget-content nopadding">
<input type="hidden" name="id" value="<?= $id; ?>">
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>     
			<div class="control-group">
			 <label class='control-label'>红包名称</label>
			  <div class='controls'>

			<?= $form->field($model, 'wallet_name',['inputOptions'=>['placeholder'=>"请输入红包名称","class"=>"name"]])->textInput(["style"=>" width:300px; height:35px;","value"=>$oneInfo->wallet_name])->label(false) ?>
			<span id="error"></span>
			  </div>
			</div>   
			<!--
			<div class="control-group">
			 <label class="control-label">是否限额 :</label>
			  <div class="controls">
			  <select name="wallet_limit" style="height:30px;width:100px;" onchange="changeLimit(this.value)" id="wallet_limit">
			  <?php if($oneInfo->wallet_is_price == 1){?>
				<option value = 1 selected>是</option>
				<option value = 0>否</option>
				<?php } else{
				?>
				<option value = 1 >是</option>
				<option value = 0 selected>否</option>
				<?php }?>
			  </select>
			</div>  
			</div>
		-->
			<div class="control-group">
			 <label class="control-label">是否显示 :</label>
			  <div class="controls">
			  <select name="wallet_show" style="height:30px;width:100px;" id="wallet_show">
			  <?php if($oneInfo->wallet_show == 1){?>
				<option value = 1 selected>是</option>
				<option value = 0>否</option>
				<?php } else{
				?>
				<option value = 1 >是</option>
				<option value = 0 selected>否</option>
				<?php }?>
			  </select>
			</div>  
			</div>



<!-- 			<div class="control-group">
			 <label class='control-label'>限定金额：</label>
			  <div class='controls'>
			
			<?= $form->field($model, 'wallet_price',['inputOptions'=>['placeholder'=>"输入限定金额"]])->textInput(["style"=>" width:300px; height:35px;","id"=>"wallet_price","value"=>floor($oneInfo->wallet_price)])->label(false) ?>
			  </div>
			</div>  --> 

			<div class="control-group">
			 <label class="control-label">分享者得到 :</label>
			 <input type="hidden" name="wallet_share" value=1 />
			  <div class="controls">	
		<?= $form->field($model, 'wallet_share',['inputOptions'=>['placeholder'=>"分享者得到","disabled"=>true]])->textInput(["style"=>" width:300px; height:35px;" ,"id" =>"wallet_share","value"=>floor($oneInfo->wallet_share_price)])->label(false) ?>
			  </div>
			</div>  

<!--             <div class="control-group">
              <label class="control-label">被分享者得到 :</label>
              <div class="controls">
               <span id="show_shares"><?php echo floor($oneInfo->wallet_shares_price)?></span>
            			   
              </div>
            </div> -->
		
			<div class="control-group">
			 <label class="control-label">被分享者得到 :</label>
			 <input type="hidden" name="wallet_shares" value=1 />
			  <div class="controls">	
		<?= $form->field($model, 'show_shares',['inputOptions'=>['placeholder'=>"被分享者得到","disabled"=>true]])->textInput(["style"=>" width:300px; height:35px;" ,"id" =>"wallet_shares","value"=>floor($oneInfo->wallet_share_price)])->label(false) ?>
			  </div>
			</div>  




			<div class="control-group">
              <label class="control-label">红包模板 :</label>
              <div class="controls">	
				<script type="text/plain" id="myEditor" style="width:400px;height:140px;" name="wallet_template">
					<p><?php echo $oneInfo->wallet_template?></p>
				</script>
			  </div>
			</div>  
 

			<div class="form-actions" style=" margin-left:190px; ">
              <button type="submit" class="btn btn-success">修改红包</button>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>


<script type="text/javascript">
//判断红包名称
function check(name,id){
	flag = 1;
	$.ajax({
	   type: "GET",
	   url: "<?= Yii::$app->urlManager->createUrl(['market/check-name']); ?>",
	   data: "name="+name+"&id="+id,
	   async:false, 
	   success: function(msg){
			if(msg['code']==400){
				flag = 0;
			}
	   }
	});
	return flag;
}
$("form").submit( function () {
	name = $(".name").val();
	id = $("input[name=id]").val();
	msg = check(name,id);
	if(msg){
		$("#error").html("");
		return true;
	}else{
		$("#error").html("<font color=red>红包名称不能重复</font>");
		return false;
	}
} );
/*

//判断是否限额
	function changeLimit(limit)
	{
		if(limit == 1){
			$("#more").hide();
		}
		if(limit == 0){
			$("#more").show();
		}
	}
	*/
	
	//页面加载事件
	$(document).ready(function(){

		var limit = $("#wallet_show option:selected").val();
		
			if(limit == 1){
				$("#more").hide();

			}
				if(limit == 0){
					$("#more").show();

			}
	});

    //实例化编辑器
    var um = UM.getEditor('myEditor');
    um.addListener('blur',function(){
        $('#focush2').html('编辑器失去焦点了')
    });
    um.addListener('focus',function(){
        $('#focush2').html('')
    });

	//失去焦点时计算被分享者得到的金额
	$("#wallet_share").blur(function(){
		share = $("#wallet_share").val();
		price = $("#wallet_price").val();
		shares = price-share;
	
		if(shares > 0){
			$("#show_shares").text(price-share);
			$(".btn").attr("disabled",false)
		}else if(shares == 0){
			$("#show_shares").text(price-share);
			$(".btn").attr("disabled",false)
		}
		if(shares < 0){
			$("#show_shares").text("输入值有误无法计算");
			$(".btn").attr("disabled",true)
		}
	});  
	
	</script>