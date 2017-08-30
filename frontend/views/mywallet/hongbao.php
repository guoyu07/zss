<?php 
use yii\helpers\Html;
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
<title>宅食送-红包</title>
</head>

<body>
	<div class="content" style="margin-bottom:5px;">
    	<div style=" height:7px; width:100%; background:#eb6877;"></div>
    	<div class="hongbao-add">
        	<span style="color:#707070;">添加红包:</span>
            <input type="text" id="hbao" placeholder="请输入红包串码">
            <a href="javascript:void(0)" class="ontrue">确定</a>
        </div>
        <!-- 红包start -->
<?php foreach ($info as $key => $value) { ?>  
 <?php if ($value["wallet_endtime"]-$time >=0){ ?>

        <div style=" height:7px; width:100%; background:#eb6877; margin-top:15px;"></div>                     
                    <?php } ?>

  <?php if ($value["wallet_endtime"]-$time <0){ ?>
 
        <div style=" height:7px; width:100%; background:#999999; margin-top:15px;"></div>                     
                    <?php } ?>                   


    
        
        <div class="hongbao-block">
        	<div class="hongbao-block-top">
                <div class="hongbao-block-left">
                	<span style="color:#ff7070; text-align:center;display:inline-block; width:80px; height:60px; line-height:70px;">¥<font style=" font-size:36px;"><?= html::encode($value["wallet_price"])?></font></span>
                    <span style="color:#ff7070; text-align:center;display:inline-block;width:80px; height:25px; font-size:12px;">满<?= html::encode($value["wallet_money"])?>可用</span>
                </div>
                
                <div class="hongbao-block-right">
                	<span style="color:#707070; width:80px; height:64px; line-height:70px; font-size:18px; display:inline-block; margin-left:10px;">支付红包</span><br>
                    <span style="color:#707070;  height:25px; font-size:12px;display:inline-block;margin-left:10px;"><?= html::encode($value["wallet_number"])?>  在线支付专享</span>
                </div>
            </div>
            
            <div class="hongbao-block-bottom">
            	<span style=" color:#ff7070; font-size:12px; float:left;margin-left:30px;">
                <?php  
                  if ($value["wallet_endtime"]-$time >=0){ 

        $begin_time = $value["wallet_endtime"];
        $end_time = $time;
$starttime = $end_time;
$endtime = $begin_time;
//计算天数
$timediff = $endtime-$starttime;
$days = intval($timediff/86400);
//计算小时数
$remain = $timediff%86400;
$hours = intval($remain/3600);
//计算分钟数
$remain = $remain%3600;
$mins = intval($remain/60);

 echo "还有".$days."天".$hours."小时失效";                    
 } else{

  echo "已经过期";

}

?>

                  

                
            </span>
                <span style=" color:#707070; font-size:12px; float:right;margin-right:30px;">有效期至: <?= date("y-m-d",$value["wallet_endtime"])?></span>
            </div>
        </div>
       
   <?php }?>     
    </div>

    <!-- 红包end -->
    <div style="width:100%; height:20px; line-height:20px; text-align:center; font-size:12px; color:707070;">使用说明</div>


<script>
  $(function(){
    $(".ontrue").click(function(){

       number = $("#hbao").val();
        if (number==""){
            
            return false;
        }else{

              location.href="<?= yii::$app->urlManager->createUrl(['mywallet/addwallet'])?>&number="+number  
        }
    })

  })
</script>
</body>
</html>
