<head>
<title>宅食送-下单-外卖-地址列表</title>
</head>
<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<body> 
<header>	
<div class="header-title">
        <span>收货地址</span>
</div>
</header> 
    <div class="content">
    	<a class="add-address-add" href="<?= Url::to(['user/addaddress'])?>"><i class="icon-plus-sign" style="margin-right:10px; color:#81181d; font-size:16px;"></i>添加收货地址</a>
        <?php foreach($address as $k => $v){?>
		<a href="<?= Url::to(['paylist/getaddress','address_type'=>$v['site_id'],'address_name'=>$v['site_detail'],'user_name'=>$v['site_name'],'user_sex'=>$v['site_sex'],'user_phone'=>$v['site_phone']])?>"> 
    	<div class="addresslist-block" >
        	<div class="left">
            	<span><?= Html::encode($v['site_name'])?>&nbsp;&nbsp;&nbsp;<?= Html::encode($v['site_phone'])?></span>
                <span><?= Html::encode($v['site_detail'])?></span>        
                <?php if($v['site_status'] == 1){?>
                <span style=" color:#de181d;"><i class=" icon-exclamation-sign" style="margin-right:10px;"></i>默认地址</span>
                <?php }else{?>
                  <span style=" color:#de181d;"><a href="javascript:void(0)" class="sz" id="<?= Html::encode($v['site_id'])?>"><i class=" icon-exclamation-sign" style="margin-right:10px;"></i>设置默认地址</a></span>
                <?php }?>
            </div>
            <a class="right" href="<?= Url::to(['user/fixaddress'])?>&id=<?= Html::encode($v['site_id'])?>">
            	<i class="icon-pencil" style="color:#81181d; font-size:20px;"></i>
            </a>
        </div>
		</a>
        <?php }?>
       

     
    </div>
</body>

