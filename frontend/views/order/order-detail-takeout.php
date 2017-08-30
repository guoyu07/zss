<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>
<!doctype html>
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
<title>宅食送－订单详情</title>
</head>

<body style=" background:#fff;">
	<script type="text/javascript">
function nTabs(thisObj,Num){
if(thisObj.className == "active")return;
var tabObj = thisObj.parentNode.id;
var tabList = document.getElementById(tabObj).getElementsByTagName("li");
for(i=0; i <tabList.length; i++)
{
  if (i == Num)
  {
   thisObj.className = "active"; 
      document.getElementById(tabObj+"_Content"+i).style.display = "block";
  }else{
   tabList[i].className = "normal"; 
   document.getElementById(tabObj+"_Content"+i).style.display = "none";
  }
} 
}
</script>
<style>
html{ min-height:100%; _height:100%;}
body{min-height: 100%;
	height:100%;}
.nTab{
float: left;
width: 100%;
margin: 0 auto;
height:100%;
min-height:100%;

}
.nTab .TabTitle{
clear: both;
height: 56px;
overflow: hidden;
width:100%;
}
.nTab .TabTitle ul{
margin:0;
padding:0;
width:180px;
height:56px;
margin:0 auto;
}
.nTab .TabTitle li{
	text-align:center;
float: left;
width:50%; line-height:30px; background-color:#81181d; color:#fff;
cursor: pointer;

padding-right: 0px;
padding-left: 0px;

list-style-type: none;

}
.nTab .TabTitle .active{ background:#81181d;}
.nTab .TabTitle .normal{ background:#fff; color:#707070;}
.nTab .TabContent{
width:100%;
margin: 0px auto;
height:100%;
min-height:100%;

}
.none {display:none;}
#myTab0_Content0， #myTab0_Content1{height:100%; min-height:100%;}

</style>
	
    <div class="nTab" >
    <!-- 标题开始 -->
        <div class="TabTitle" style="height:30px;">
          <ul id="myTab0" style=" width:100%;height:30px;">
            <li class="active" onclick="nTabs(this,0);" >订单状态</li>
            <li class="normal" onclick="nTabs(this,1);" >订单详情</li>
          </ul>
        </div>
        
        <div class="TabContent">
        <!-- 外卖开始 -->
          <div id="myTab0_Content0" style="display:block;" > 
          		<div class="content" style="margin-bottom:0;height:100%; min-height:100%;">
                	<p style="padding-left:30px; font-size:12px; line-height:30px; display:block; background:#f4f6f0;">订单状态</p>
                    <div style="float:left; min-height: 50%;height:50%;width:28px; border-right:2px solid #e5e5e5; position:absolute; overflow:hidden;">
                    </div>
                    <!--堂食订单递交成功-->
                    <div style="background:#fff; position:relative;margin-left:30px;border-bottom:1px solid #e5e5e5;font-size:12px; ">
                    	<div style="overflow:auto; padding:10px 0;">
                        	<h3 style=" float:left; margin-left:15px;">订单递交成功</h3>
                        </div>
                        <div style="overflow:auto; padding:0 0 10px 0;">
                            <p style=" float:left; font-size:9px; color:#707070;margin-left:15px;">您的取餐号为：<font style="color:#81181d;font-size:12px;"><?= HtmlPurifier::process($list['meal_number']) ?></font></p>
                            <p style=" float:right; margin-right:30px;color:#707070;font-size:12px;">
							<?php 
								if($list['created_at'])
								{ 
									echo HtmlPurifier::process(date('H:i:s',$list['created_at']));
								} 
							?>
							</font></p>		
                        </div>
                        <i class="icon-circle" style=" color:#e5e5e5;position:absolute; top:25px; left:-6px; "></i>
						
                        
                     </div>
                     
                      <!--支付成功-->
                     <div style="background:#fff; width:100%; height:100%; ">
                    	
                        <div style=" border-bottom:1px solid #e5e5e5;position:relative; margin-left:30px; display:block; font-size:12px;">
                        	<div style="width:100%;">
                            	<div style="overflow:auto; padding:10px 0;">
                                    <h3 style=" float:left; margin-left:15px;">支付成功，等待小宅接单</h3>
                                    <p style=" float:right; margin-right:30px;color:#707070;font-size:12px;">
									<?php 
									if($list['pay_at'])
									{ 
										echo HtmlPurifier::process(date('H:i:s',$list['pay_at']));
									} 
									?>
									</font></p>	
                                    	
                                </div>
                                
                               
                            </div>
                            <i class="icon-circle" style=" color:#e5e5e5;position:absolute; top:12px; left:-6px; "></i>
                        </div>
                     </div>
                     
                     <div style="background:#fff; width:100%; height:100%; ">
                    	
                        <div style="border-bottom:1px solid #e5e5e5;position:relative; margin-left:30px; display:block; font-size:12px;">
                        	<div style="width:100%;">
                            	<div style="overflow:auto; padding:10px 0;">
                                    <h3 style=" float:left; margin-left:15px;">小宅已确认订单，美食准备中～</h3>
                                    <p style=" float:right; margin-right:30px;color:#707070;font-size:12px;">
									<?php 
									if($list['confirm_time'])
									{ 
										echo HtmlPurifier::process(date('H:i:s',$list['confirm_time']));
									} 
									?>
									</font></p>	
                                    	
                                </div>
                                
                               
                            </div>
                            <i class="icon-circle" style=" color:#e5e5e5;position:absolute; top:12px; left:-6px; "></i>
                        </div>
                     </div>
                     
                     <div style="background:#fff; width:100%; height:100%; ">
                    	
                        <div style="border-bottom:1px solid #e5e5e5;position:relative; margin-left:30px; display:block; font-size:12px;">
                        	<div style="width:100%;">
                            	<div style="overflow:auto; padding:10px 0;">
                                    <h3 style=" float:left; margin-left:15px;">小宅骑士正在配送中，请您耐心等待</h3>
                                </div>
                            	<div style="overflow:auto; padding:0 0 5px 0;">
                                    <p style=" float:left; margin-left:15px; font-size:9px; color:#707070;">骑士:<?= HtmlPurifier::process($distribution['username']) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电话:<?= HtmlPurifier::process($distribution['phone']) ?></p>
                                    <p style=" float:right; margin-right:30px;color:#707070;font-size:12px;">
									<?php 
									if($distribution['add_time'])
									{ 
										echo HtmlPurifier::process(date('H:i:s',$distribution['add_time']));
									} 
									?>
									</font></p>	
                                    	
                                </div>
                                <div style="overflow:auto; padding:0 0 5px 0;">
                                    <p style=" float:left; margin-left:15px; font-size:9px; color:#707070;">预计<?= HtmlPurifier::process(date('H:i',$distribution['add_time']+1800)) ?>送达</p>
                                </div>
                                
                               
                            </div>
                            <i class="icon-circle" style=" color:#e5e5e5;position:absolute; top:32px; left:-6px; "></i>
                        </div>
                     </div>
                     
                     
                     
                     <div style="background:#fff; width:100%; height:100%; ">
                    	<div style=" margin-left:30px; display:block;position:relative; font-size:12px;">
                        	<div style="width:100%;">
                            	<div style="overflow:auto; padding:10px 0;">
                                    <h3 style=" float:left; margin-left:15px;">订单已完成</h3>
                                    <p style=" float:right; margin-right:30px;color:#707070;font-size:12px;">
									<?php 
									if($list['order_success'])
									{ 
										echo HtmlPurifier::process(date('H:i:s',$list['order_success']));
									} 
									?>
									</font></p>	
                                </div>
                            </div>
                            <i class="icon-circle" style=" color:#e5e5e5;position:absolute; top:12px; left:-6px; "></i>
                        </div>
                     </div>
                     
                     <div style="background:#fff; width:100%; height:100%; overflow:visible;border-left:1px solid #e5e5e5;  margin-left:30px; ">
                    	
                     </div>
                    
                </div>
               
          </div>
          
          
          <div id="myTab0_Content1" style="display:none;"> 
          		<div class="content" style="margin-bottom:0;height:100%; min-height:100%;">
                	<p style="padding-left:30px; font-size:12px; line-height:30px; display:block; background:#f4f6f0;">订单详情</p>
                    <div style="background:#fff; border-bottom:1px solid #e5e5e5;font-size:12px; ">
                    	<div class="order-info">
                        <div class="order-info-dish">
                           <?php foreach($list['info'] as $key=>$value): ?>
									<div class="order-info-dish-block" >
										<span><?= HtmlPurifier::process($value['menu_name']) ?></span>
										<span style="float:right; margin-right:30px;color:#333;">¥ <?= HtmlPurifier::process($value['menu_price']*$value['menu_num']) ?></span>
										<span style="float:right;margin-right:30px; ">¥ <?= HtmlPurifier::process($value['menu_price']) ?> x <?= HtmlPurifier::process($value['menu_num']) ?></span>
									</div>
							<?php endforeach; ?>
                        </div>
                        <div class="order-info-fee">
                            <div class="order-info-fee-block">
                                <span>餐盒费</span>
                                <span style="float:right; margin-right:30px;color:#333;">¥ <?= HtmlPurifier::process($list['lunchbox']) ?></span>
                            </div>
                            <div class="order-info-fee-block">
                                <span>配送费</span>
                                <span style="float:right; margin-right:30px;color:#333;">¥ <?= HtmlPurifier::process($list['order_freight']) ?></span>
                            </div>
                        </div>
                        <div class="order-info-m">
                           <div class="order-info-m-block">
                                    <span>红包</span>
                                    <span style="float:right; margin-right:30px;color:#333;">¥ -<?= HtmlPurifier::process($list['wallet']) ?></span>
                                </div>
                                <div class="order-info-m-block">
                                    <span>满减优惠</span>
                                    <span style="float:right; margin-right:30px;color:#333;">¥ -<?= HtmlPurifier::process($list['sub']) ?></span>
                                </div>
                                 <div class="order-info-m-block">
                                    <span>优惠券</span>
                                    <span style="float:right; margin-right:30px;color:#333;">¥ -<?= HtmlPurifier::process($list['coupon']) ?></span>
                                </div>
                        </div>
                        <div class="order-info-total">
                           <span>总计¥ <?= HtmlPurifier::process($list['order_total']) ?> &nbsp;&nbsp;&nbsp;优惠¥ <?= HtmlPurifier::process($list['order_total']-$list['order_payment']) ?></span>
                                <span style="float:right; margin-right:30px;color:#333;">实付&nbsp;<font color="#81181d">¥ <?= HtmlPurifier::process($list['order_payment']) ?></font></span>
                        </div>
                        
                    </div>
            	</div>
                <!--配送信息-->
                <p style="padding-left:30px; font-size:12px; line-height:30px; display:block; background:#f4f6f0;">配送信息</p>
                    <div style="background:#fff; border-bottom:1px solid #e5e5e5;font-size:12px; ">
                    	<div class="order-info">
                        <div class="order-info-dish">
                            <div class="order-info-dish-block" >
                                <span>期望时间</span>
                                <span style="float:left; margin-left:20px;color:#333; font-weight:bold;">立即配送</span>
                                
                            </div>
                        </div>
                        <div class="order-info-fee">
                            <div class="order-info-dish-block" style="height:40px !important;">
                            	<div style="width:75px; height:40px; float:left;">
                                	<span>配送地址</span>
                                </div>
                                <span style="float:left; width:200px; margin-left:10px;color:#333;font-weight:bold; "><?= HtmlPurifier::process($list['user_name']) ?><?= HtmlPurifier::process($list['user_phone']) ?></span>
                                <span style="float:left; margin-left:10px; color:#333;display:block;font-weight:bold;"><?= HtmlPurifier::process($list['order_address']) ?></span>
                            </div>
                        </div>
                        <div class="order-info-m">
                            <div class="order-info-dish-block" >
                                <span>配送骑士</span>
                                <span style="float:left; margin-left:20px;color:#333;font-weight:bold;"><?= HtmlPurifier::process($distribution['username']) ?></span>
                                
                            </div>
                        </div>
                    </div>
            	</div>
                <!--配送信息借结束--->
                
                <!--订单信息-->
                <p style="padding-left:30px; font-size:12px; line-height:30px; display:block; background:#f4f6f0;">订单信息</p>
                    <div style="background:#fff; border-bottom:1px solid #e5e5e5;font-size:12px; ">
                    	<div class="order-info">
                        <div class="order-info-dish">
                            <div class="order-info-dish-block" >
                            	<div style="width:75px; height:40px; float:left;">
                                	<span>订单号</span>
                                </div>
                                <span style="float:left; margin-left:10px;color:#333;font-weight:bold;"><?= HtmlPurifier::process($list['order_sn']) ?></span>
                                
                            </div>
                        </div>
                        <div class="order-info-fee">
                            <div class="order-info-dish-block"  >
                                <span>下单时间</span>
                                <span style="float:left; margin-left:20px;color:#333;font-weight:bold; "><?= HtmlPurifier::process(date('H:i:s',$list['created_at'])) ?></span>
                               
                                
                            </div>
                        </div>
                        <div class="order-info-m">
                            <div class="order-info-dish-block" >
                                <span>支付方式</span>
                                <span style="float:left; margin-left:20px;color:#333;font-weight:bold;">
									<?php if($list['payonoff']=="online"){ echo "线上支付"; }elseif($list['payonoff']=="balance"){ echo "线下支付"; }?>
								</span>
                                
                            </div>
                        </div>
                    </div>
            	</div>
                <!--订单信息信息借结束--->
          	</div>
          </div>
        </div>
        
        
        
    </div>
    
    <footer>
            <a style="border-right:1px solid #fff;"  href="<?= Url::to(['index/index'])?>" >点餐</a>
        <a style="background:#510c0f" href="<?= Url::to(['order/index']);?>" >订单</a>
        <a style="border-right:1px solid #fff;" href="<?= Url::to(['user/index'])?>">会员</a>
    </footer>
</body>
</html>
