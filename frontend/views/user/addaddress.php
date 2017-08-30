<title>宅食送-下单-外卖-添加地址</title>
</head>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<body>
    <div class="content">
        <?php $form = ActiveForm::begin(); ?>
    	<p style="margin-left:10px; font-size:12px; line-height:30px;">联系人</p>
        <div style="background:#fff; width:100%;">
        	<div style="border-bottom:1px solid #fff; height:40px;">
            	<span style="margin-left:10px; line-height:40px; font-size:12px;">姓名：</span>
                <input  name="AddressForm[username]" style="line-height:25px; width:80%; border:none;outline:none;" placeholder="请填写收货人的姓名"/> 
                <font style='text-align: center; font-size:12px;color:red'><?= Html::error($model,'username')?></font> 
            </div>
           <br/>
            <div style="border-bottom:1px solid #fff; height:40px;">
            	<span style="margin-left:10px; line-height:40px; font-size:12px;">电话：</span>
                <input name="AddressForm[phone]" style="line-height:25px; width:80%; border:none;outline:none;" placeholder="请填写收货人的手机号码">
                <font style='text-align: center; font-size:12px;color:red'><?= Html::error($model,'phone')?></font> 
            </div>
           <br/>
            <div style="width:40%; height:40px; margin:0 auto;">
            	<input type="radio" name='sex' checked="checked"  value="先生" id="male" style=""/><label for="male" class="check-box" style="float:left;"></label><span style="font-size:12px; line-height:25px;float:left; display:block; margin-left:10px; margin-right:30px; color:#707070;">先生</span>
              
                <input type="radio"  name="sex" value="女士" id="female" style=" margin-left:40px;"/><label  for="female" class="check-box" style="float:left;"></label><span style="font-size:12px; line-height:25px;float:left; display:block;  color:#707070;">女士</span>
               
                <script>
                    $(':radio').click(function(){if(this.checked)$(this).next().css('color','red')});
		</script>
            </div>
        </div>
        <p style="margin-left:10px; font-size:12px; line-height:30px;">收货地址</p>
        <div style="background:#fff; width:100%;">
        	<div style="border-bottom:1px solid #fff; height:40px;">
            	<span style="margin-left:10px; line-height:40px; font-size:12px;">小区/大厦/学校：</span>
                <input  name='AddressForm[address]' style="line-height:25px; width:50%; border:none;outline:none;" placeholder="请输入送餐地址">
                 <font style='text-align: center; font-size:12px;color:red'><?= Html::error($model,'address')?></font> 
            </div>
            <br/>
            <div style="border-bottom:1px solid #fff; height:40px;">
            	<span style="margin-left:10px; line-height:40px; font-size:12px;">楼好-门牌号：</span>
                <input name='AddressForm[localnum]' style="line-height:25px; width:50%; border:none; outline:none;" placeholder="例：c座1526">
            </div>
        </div>
                     <font style='text-align: center; font-size:12px;color:red'><?= Html::error($model,'localnum')?></font> 
        <button type="submit" style="margin-right:20px; margin-top:10px; float:right; padding:7px 15px; background:#81181d; color:#fff; border:none;">保存</button>
        <?php ActiveForm::end(); ?>
    </div>
</body>
</html>
