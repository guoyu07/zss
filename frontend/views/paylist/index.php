<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
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
<title>宅食送-下单</title>
</head>

<body>
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
.nTab{
float: left;
width: 100%;
margin: 0 auto;
border-bottom:1px #C7C7CD solid;

background-position:left;
background-repeat:repeat-y;
margin-bottom:2px;
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
width: 60px;
cursor: pointer;

padding-right: 0px;
padding-left: 0px;

list-style-type: none;
line-height:56px;
}
.nTab .TabTitle .active{ background:#fff;}
.nTab .TabTitle .normal{ background:url(images/tab_bg1.gif);}
.nTab .TabContent{
width:auto;background:#fff;
margin: 0px auto;
padding:10px 0 0 0;
border-right:1px #C7C7CD solid;border-left:1px #C7C7CD solid;
}
.none {display:none;}
</style>
	<div class="nTab">
    <!-- 标题开始 -->
        
    <!-- 内容开始 -->
        <div class="TabContent">
        <!-- 堂食开始 -->
          <div id="myTab0_Content0"> 
          		<div class="content">
                    <div class="payment-info">
                        <div class="payment-info-table">
                            <label>添加桌号</label>
                            <input placeholder="如 03" style="line-height:30px; margin-left:20px; outline:none;" onkeypress="return IsNum(event)">
                        </div>
                        <div class="payment-method">
                            <span>支付方式</span>
                            <a href="#">线上支付></a>
                        </div>
                        <div class="payment-hongbao">
                            <span>宅食红包</span>
                            <a href="#">¥ 1.0 元红包></a>
                        </div>
                        <div class="payment-coupon">
                            <span>宅食优惠卷</span>
                            <a href="#">暂无可用优惠卷></a>
                        </div>
                        
                    </div>
                        <p style=" margin-left:30px; font-size:12px; line-height:30px;">订单信息</p>
                    <div class="order-info">
                        <div class="order-info-dish">
                            <div class="order-info-dish-block" >
                                <span>香菇鸡肉套餐</span>
                                <span style="float:right; margin-right:30px;color:#333;">¥52</span>
                                <span style="float:right;margin-right:30px; ">¥26x2</span>
                            </div>
                            <div class="order-info-dish-block">
                                <span>台式卤肉饭</span>
                                <span style="float:right; margin-right:30px;color:#333;">¥24</span>
                                <span style="float:right;margin-right:30px; ">¥24x1</span>
                            </div>
                        </div>
                        
                        <div class="order-info-m">
                            <div class="order-info-m-block">
                                <span>红包</span>
                                <span style="float:right; margin-right:30px;color:#333;">-¥3</span>
                            </div>
                            <div class="order-info-m-block">
                                <span>满减优惠</span>
                                <span style="float:right; margin-right:30px;color:#333;">-¥4</span>
                            </div>
                            
                        </div>
                        <div class="order-info-total">
                            <span>总计¥172 &nbsp;&nbsp;&nbsp;优惠¥38</span>
                            <span style="float:right; margin-right:30px;color:#333;">实付&nbsp;<font color="#81181d">¥115</font></span>
                        </div>
                        <div class="order-info-comments">
                            <p>备注</p>
                            <textarea name="MSG" cols=40 rows=4 style=" width:80%; margin-left:30px;" placeholder="不要辣"></textarea>
                        </div>
                    </div>
                </div>
                <footer style="background:#fff;">
                    <span style="float:left; line-height:49px; font-size:10px; color:#707070; margin-left:30px;">已优惠¥34</span>
                    <a style="float:right; font-size:18px;width:89px; height:49px; background:#81181d; color:#fff; line-height:49px;" href="order.html">提交订单</a>
                    <span style="float:right;line-height:49px; font-size:18px; color:#81181d; margin-right:20px;  ">¥341</span>
                    <span style="float:right;line-height:49px; font-size:10px; color:#707070; margin-right:2px;  ">待支付</span>
                </footer>
          </div>
          
          <!-- 堂食结束 -->
          
         
          
          <!-- 自提结束 -->
        </div>
        <!-- 内容结束 -->
	</div>

<div class="pay-list-pop"></div>
<div class="pay-list-pop-content">
	
	<div class="block">
    	<a href="<?= Url::to(['paylist/paylist2'])?>">堂食</a>
    </div>
    <div class="block">
        <a href="<?= Url::to(['paylist/paylist'])?>">外卖</a>
    </div>
    <div class="block">
        <a href="<?= Url::to(['paylist/paylist3'])?>">自提</a>
    </div>
</div>

</body>
</html>
