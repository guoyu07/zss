<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<head>
<title>宅食送-会员中心</title>
</head>

<body>
	<div class="content">
    	<a class="user-header" href="<?= Url::to(['user/userinfo'])?>">
        	<div class="user-pic">
            	<img style=" border-radius:50%; width:43px; height:43px;display:block; margin-top:9px; float:left;" src="<?= $userphoto?>">
                <span style="margin-left:10px; font-size:12px;">普通会员</span>
            </div>
            <div style="line-height:85px; float:right; margin-right:30px; font-size:22px;">></div>
        </a>
        <div class="user-info">
        	<div class="user-info-block">
                <a class="user-info-block-1" href="<?= Url::to(['user/charge'])?>">
                    <span style="line-height:25px; font-size:18px; color:#ff7070;"><?= Html::encode(isset($user['user_price'])?$user['user_price']:0) ?>元</span><br>
                    <span style="line-height:15px; font-size:12px; color:#707070; "><img src="img/icon-yue.png" height="14px" width="14px" >余额</span>
                </a>
                <a class="user-info-block-1" href="<?= Url::to(['mywallet/index'])?>">
                    <span style="line-height:25px; font-size:18px; color:#ff7070;"><?= Html::encode($w_num)?>个</span><br>
                    <span style="line-height:15px; font-size:12px; color:#707070; "><img src="img/icon-hongbao.png" height="14px" width="14px" >红包</span>
                </a>
                <a class="user-info-block-1" href="<?= Url::to(['mywallet/coupon'])?>"> 
                    <span style="line-height:25px; font-size:18px; color:#ff7070;"><?= Html::encode($c_num)?>张</span><br>
                    <span style="line-height:15px; font-size:12px; color:#707070; "><img src="img/icon-daijinquan.png" height="14px" width="14px" >代金券</span>
                </a>
            </div>
        </div>
        <div class="user-block">
        	<a href="<?= Url::to(['user/virtual'])?>" >
            	<span style="float:left; margin-left:15px; font-size:12px; font-weight:bold;"><img src="img/icon-jf.png" height="18px" width="18px" style="vertical-align:middle; margin-bottom:1px; margin-right:10px;" >我的积分</span>
                <span style="float:right; margin-right:30px; color:#d2d2d2;">></span>
                
            </a>
            <a href="<?= Url::to(['user/addlist'])?>" >
            	<span style="float:left; margin-left:15px; font-size:12px; font-weight:bold;"><img src="img/icon-address.png" height="18px" width="18px" style="vertical-align:middle; margin-bottom:1px; margin-right:10px;" >管理收货地址</span>
                <span style="float:right; margin-right:30px;color:#d2d2d2;">></span>
                
            </a>
        </div>
        <div class="user-block" style="margin-top:10px;">
        	<a href="#" >
            	<span style="float:left; margin-left:15px; font-size:12px; font-weight:bold;"><img src="img/icon-help.png" height="18px" width="18px" style="vertical-align:middle; margin-bottom:1px; margin-right:10px;" >意见反馈</span>
                <span style="float:right; margin-right:30px;color:#d2d2d2;">></span>
                
            </a>
            <a href="<?= Url::to(['order/index'])?>&userid=<?= $userid['user_id']?>" >
            	<span style="float:left; margin-left:15px; font-size:12px; font-weight:bold;"><img src="img/icon-more.png" height="18px" width="18px" style="vertical-align:middle; margin-bottom:1px; margin-right:10px;" >我的订单</span>
                <span style="float:right; margin-right:30px;color:#d2d2d2;">></span>
                
            </a>
              <a href="<?= Url::to(['user/charge'])?>" >
            	<span style="float:left; margin-left:15px; font-size:12px; font-weight:bold;"><img src="img/icon-more.png" height="18px" width="18px" style="vertical-align:middle; margin-bottom:1px; margin-right:10px;" >余额充值</span>
                <span style="float:right; margin-right:30px;color:#d2d2d2;">></span>
                
            </a>
        </div>
    </div>
    <footer>
    	<a style="border-right:1px solid #fff;" href="<?= Url::to(['index/index'])?>"><img src="img/icon-diancan.png" >点餐</a>
        <a style="border-right:1px solid #fff;" href="<?= Url::to(['order/index'])?>&userid=<?= $userid['user_id']?>"><img src="img/icon-dingdan.png"  >订单</a>
        <a  style="border-right:#510c0f;" href="<?= Url::to(['user/index'])?>"><img src="img/icon-user.png" >会员</a>
    </footer>
</body>
</html>
