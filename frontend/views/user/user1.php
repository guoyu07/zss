<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<html>
    
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="css/style.css" media="all">
<link rel="stylesheet" type="text/css" href="css/slidernav.css" media="screen, projection" />
<link rel="stylesheet" href="css/font-awesome.css" media="all">
<link rel="stylesheet" href="css/font-awesome.min.css" media="all">
<title>宅食送-我的</title>
</head>

<body>

	<div class="content">
    	<div class="user-header">
        
        </div>
        <div class="user-info">
        	<div class="user-info-block">
                <div class="user-info-block-1">
			    <a style="color:grey;" href="<?= Url::to(['user/charge'])?>" >
                    <span style="line-height:25px; font-size:24px; color:#ff7070;"><?= Html::encode(isset($user['user_price'])?$user['user_price']:0) ?></span><br>
                    <span style="line-height:15px; font-size:12px; color:#707070;">余额</span>
			   	</a>
                </div>
                <div class="user-info-block-1">
                <a style="color:grey;" href="<?= Url::to(['mywallet/index'])?>" >
					<span style="line-height:25px; font-size:24px; color:#ff7070;"><?= Html::encode($w_num)?></span><br>
                    <span style="line-height:15px; font-size:12px; color:#707070;"> 红包</span>
				</a>             
                </div>
                <div class="user-info-block-1" style="border:none;">
				<a style="color:grey;" href="<?= Url::to(['mywallet/coupon'])?>" >
                	<span style="line-height:25px; font-size:24px; color:#ff7070;"><?= Html::encode($c_num)?></span><br>
                    <span style="line-height:15px; font-size:12px; color:#707070;">代金卷</span> 
				</a>    
                </div>
            </div>
        </div>
        <div class="user-block">     	
            <a href="<?= Url::to(['user/virtual'])?>">
				<span style="float:left; margin-left:30px;">我的积分</span>
                <span style="float:right; margin-right:30px;">></span>
                
            </a>
            <a href="<?= Url::to(['user/addlist'])?>" >
            	<span style="float:left; margin-left:30px;">管理收货地址</span>
                <span style="float:right; margin-right:30px;">></span>
                
            </a>
        </div>
        <div class="user-block" style="margin-top:10px;">
        	<a href="#" >
            	<span style="float:left; margin-left:30px;">意见反馈</span>
                <span style="float:right; margin-right:30px;">></span>
                
            </a>
            <a href="<?= Url::to(['order/index'])?>" >
            	<span style="float:left; margin-left:30px;">我的订单</span>
                <span style="float:right; margin-right:30px;">></span>
                
            </a>
            <a href="<?= Url::to(['user/charge'])?>">
				<span style="float:left; margin-left:30px;">余额充值</span>
                <span style="float:right; margin-right:30px;">></span>
                
            </a>
        </div>
    </div>
    <footer>
    	<a style="border-right:1px solid #fff;"  href="<?= Url::to(['index/index'])?>">点餐</a>
        <a style="border-right:1px solid #fff;" href="<?= Url::to(['order/index'])?>">订单</a>
        <a  style="background:#510c0f" href="<?= Url::to(['user/index'])?>">会员</a>
    </footer>
</body>
</html>
