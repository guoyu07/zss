<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<head>
<?=Html::cssFile('css/jquery-labelauty.css')?>


<link rel="stylesheet" type="text/css" href="css/slidernav.css" media="screen, projection" />
<title>宅食送－余额</title>
<style type="text/css">
.dowebok ul{list-style-type: none;}
.dowebok li{display: inline-block;}
.dowebok li{margin: 10px 0;}
input.labelauty + label{font:12px "Microsoft Yahei";}
</style>
</head>

<body>
	<div class="content">
    	<div 
    	<div class="yue-top">
            <?php $form = ActiveForm::begin(); ?>
        	<h2>余额</h2>
            <h1>¥<?= Html::encode(isset($udata['user_price'])?$udata['user_price']:0)?></h1>
        	<span id="huan"></span>
                <input type="hidden" name="hidden" id="hidden" value="">
            <ul class="dowebok">
                <?php  foreach($rebate as $rk => $rv){?>
                <li><input type="radio" name="fan" data-labelauty="充<?=Html::encode($rv['rebate_price'])?>元返<?=Html::encode($rv['rebate_send'])?>" id="<?=Html::encode($rv['rebate_id'])?>"zhi='<?=Html::encode($rv['rebate_price'])?>' value="充<?=Html::encode($rv['rebate_price'])?>元返<?=Html::encode($rv['rebate_send'])?>"></li>
                <?php }?>
                <br>
                <li><input type="text" name="ChargeForm[money]" id="money" placeholder="充值任意金额" style="padding:10px 30px; text-align:center; font-size:12px;" onkeypress="return IsNum(event)"></li>
                <font style='text-align: center; font-size:12px;color:red'><?= Html::error($model,'money')?></font>
                <script language="javascript" type="text/javascript">
                    function IsNum(e) {
                        var k = window.event ? e.keyCode : e.which;
                        if (((k >= 48) && (k <= 57)) || k == 8 || k == 0) {
                        } else {
                            if (window.event) {
                                window.event.returnValue = false;
                            }
                            else {
                                e.preventDefault(); //for firefox 
                            }
                        }
                    } 
                </script>
            </ul>
                <button type="submit">充值</button>
                <?php ActiveForm::end(); ?>
        </div>
        <p style="margin-left:30px; padding:5px 0;">充值记录</p>
        <div class="yue-record">
        	<ul>
            	<li>
                	<span>支付类型</span>
                    <span>充值金额</span>
                    <span>赠送金额</span>
                    <span>日期</span>
                </li>
                <?php foreach($charge as $ck => $cv){?>
                <li>
                    <span>
                        <?php if($cv['charge_type'] == 0){?>
                            <?= Html::encode("余额支付")?>
                        <?php }elseif($cv['charge_type'] == 1){ ?>
                            <?= Html::encode("微信支付")?>
                        <?php }?>
                    </span>
                    <span>¥<?= Html::encode($cv['charge_money'])?></span>
                    <span>¥<?= Html::encode($cv['charge_send'])?></span>
                    <span><?= Html::encode(date("H:i:s",$cv['created_at']))?></span>
                </li>
                <?php }?>
                
            </ul>
        </div>
    </div>


<?=Html::jsFile('js/jquery-labelauty.js')?>
            
<script type="text/javascript">
$(function(){
	$(':input').labelauty();
        $("input[name='fan']").click(function(){
           //获取按钮内的值
           var fan = $(this).val()
           //将按钮内的值替换到上面显示出来
           $("#huan").html(fan)  
           //讲id赋给隐藏域
           $("#hidden").attr("value",$(this).attr("id"))
           //将值赋给下面文本框
           var zhi = $(this).attr('zhi')
           $("#money").attr("value",zhi)
        })
});
</script>
</body>
</html>
