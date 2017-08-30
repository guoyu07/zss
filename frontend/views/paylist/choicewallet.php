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
<title>宅食送-红包</title>
</head>

<body>
	<div class="content" style="margin-bottom:5px;">     
      
		<?php 
		
			foreach($wallet as $k=>$v){
				$day = floor(($v['wallet_endtime'] - time())/60/60/24);//剩余到期时间 单位---天
				if($day > 0){ ?>
				<a href="<?= Url::to(['paylist/getware','wallet_type'=>$v['wallet_id']])?>">
				<div style=" height:7px; width:100%; background:#eb6877; margin-top:15px;"></div>
					<div class="hongbao-block">
						<div class="hongbao-block-top">
							<div class="hongbao-block-left">
								<span style="color:#ff7070; text-align:center;display:inline-block; width:80px; height:60px; line-height:70px;">￥<font style=" font-size:36px;"><?php echo $v['wallet_price']?></font></span>
								<span style="color:#ff7070; text-align:center;display:inline-block;width:80px; height:25px; font-size:12px;"></span>
							</div>
							
							<div class="hongbao-block-right">
								<span style="color:#707070; width:80px; height:64px; line-height:70px; font-size:18px; display:inline-block; margin-left:10px;">支付红包</span><br>
								<span style="color:#707070;  height:25px; font-size:12px;display:inline-block;margin-left:10px;">   在线支付专享</span>
							</div>
						</div>
						
						<div class="hongbao-block-bottom">
							<span style=" color:#ff7070; font-size:12px; float:left;margin-left:30px;">还有<?php echo $day;?>天过期</span>
							<span style=" color:#707070; font-size:12px; float:right;margin-right:30px;">有效期至: <?php echo date("Y-m-d",$v['wallet_endtime']);?></span>
						</div>
					</div>
				</a>
					
			<?php	}else{ ?>

					 <div class="hongbao-block">
					<div class="hongbao-block-top">
						<div class="hongbao-block-left">
							<span style="color:#707070; text-align:center;display:inline-block; width:80px; height:60px; line-height:70px;">￥<font style=" font-size:36px;"><?php echo $v['wallet_price']?></font></span>
							<span style="color:#707070; text-align:center;display:inline-block;width:80px; height:25px; font-size:12px;"></span>
						</div>
						
						<div class="hongbao-block-right">
							<span style="color:#707070; width:80px; height:64px; line-height:70px; font-size:18px; display:inline-block; margin-left:10px;">支付红包</span><br>
							<span style="color:#707070;   height:25px; font-size:12px;display:inline-block;margin-left:10px;">   在线支付专享</span>
						</div>
					</div>
					
					<div class="hongbao-block-bottom">
						<span style=" color:#707070; font-size:12px; float:left;margin-left:30px;">已过期</span>
						<span style=" color:#707070; font-size:12px; float:right;margin-right:30px;">有效期至: <?php echo date("Y-m-d",$v['wallet_endtime']);?></span>
					</div>
				</div>

				
		<?php		}
			}
		?>
		




    <div style="width:100%; height:20px; line-height:20px; text-align:center; font-size:12px; color:707070;">使用说明</div>

</body>
</html>
