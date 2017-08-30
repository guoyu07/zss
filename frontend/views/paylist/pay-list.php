<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
	<div class="content">

<form method="post" action="<?= yii::$app->urlManager->createUrl(['paylist/paylist'])?>">
  <input type="hidden" id="tt" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
     	<div class="payment-info">
		
        	<div class="payment-info-address">
			<?php if($address == 0){?>
            	<a href="index.php?r=user/addaddress" class="add"><i class="icon-plus" style="color:#81181D; margin-right:10px;"></i>添加地址</a>
				<input type="hidden" value="" id='address' name='address'>
			<?php }else { 
					if(isset($_COOKIE['address_id'])){
						$choiceaddress = $_COOKIE['address_id'];
					}
					if(!$choiceaddress){ 
				?>
                 <a class="choose" href="index.php?r=paylist/choiceaddress">
                                <div class="left">
                                    <p><?php echo $address['site_name'];?>&nbsp;&nbsp;&nbsp;<?php echo $address['site_sex'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $address['site_phone'];?></p>
                                    <p><?php echo $address['site_detail'];?></p>
                                </div>
								<input type="hidden" value="<?php echo $address['site_id'];?>" id='address' name='address'>
                                <div class="right">
                                   选择其他地址 >
                                </div>
                 </a>
			<?php }else{ ?>
                 <a class="choose" href="index.php?r=paylist/choiceaddress">
                                <div class="left">
                                    <p><?php echo $_COOKIE['uname'];?>&nbsp;&nbsp;&nbsp;<?php echo $_COOKIE['usex'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_COOKIE['uphone'];?></p>
                                    <p><?php echo $_COOKIE['address_name'];?></p>
                                </div>
								<input type="hidden" value="<?php echo $_COOKIE['address_id'];?>" id='address' name='address'>
                                <div class="right">
                                   选择其他地址 >
                                </div>
                 </a>				
				
				
			<?php } } ?>
               
            </div>
			<input type='hidden' name='paytype' value="1">
            <div class="payment-method">
            	<span>支付方式</span>
                <a href="javascript:void(0)">     
				<div class='div'>
				<select name="payonoff" id="payonoff"/>
					<option value="online">微信支付</option>
					<option value="balance" selected >会员支付</option>
				</select>
				</div>
				</a>
            </div> 
			
            <div class="payment-hongbao">
            	<span>宅食红包</span>
  				<?php 
				if(isset($_COOKIE['wallet_id'])){
					$choicewallet = $_COOKIE['wallet_id'];
				}
				if($choicewallet){
					echo "<a href=\"index.php?r=paylist/choicewallet\">".'¥ 1元红包'."</a>";
					echo "<input type='hidden' name='wallet' value=".$_COOKIE['wallet_id'].">";
					$wallet=1;
				}else{ 
				if( $wallet ){
					echo "<a href=\"index.php?r=paylist/choicewallet\">选择红包</a>";
					echo "<input type='hidden' name='wallet' value='0'>";
					$wallet=0;
				}else{
					echo '<a>无可用红包</a>';
					echo "<input type='hidden' name='wallet' value='0'>";
					$wallet=0;
				} }?> 
            </div>
            <div class="payment-coupon">
            	<span>宅食优惠卷</span>
               
				<?php 
				$allPrice = 0;		//订单商品的实际总价格
				foreach($menu as $k=>$v){
					$allPrice += $v['menu_price']*$v['num'];
				}
				$choicecoupon = isset($_COOKIE['c_price']);
				
				if($coupon == 0){
					echo "<a>没有可用的优惠券</a>";
					echo "<input type='hidden' name='coupon' value='0'>";
					$couponPrice =0;
				}else{
					if($choicecoupon){
						echo "<a href=\"index.php?r=paylist/choicecoupon&all=$allPrice\">".$_COOKIE['c_price']."</a>";
						echo "<input type='hidden' name='coupon' value='".$_COOKIE['c_price']."'>";
						$couponPrice = $_COOKIE['c_price'];
					}else{
						echo "<a href=\"index.php?r=paylist/choicecoupon&all=$allPrice\">选择优惠券</a>";
						echo "<input type='hidden' name='coupon' value='0'>";
						$couponPrice = 0;
					}
				}?>
            </div>
            <div class="payment-delivery">
            	<span>外送方式</span>
				<a>宅食自配送
				<input type="hidden" name='gettype' value="宅食自配送">
				</a>
            </div>
        </div>
        	<p style=" margin-left:30px; font-size:12px; line-height:30px;">订单信息</p>
        <div class="order-info">
        	<div class="order-info-dish">
  	<!--显示订单的菜品信息-->
		<?php 
		$arrId = array();	//定义数组 -- 订单中菜品的ID
		$menunum = array(); //定义数组 -- 订单中菜品的数量
		$menuprice = array(); //定义数组 -- 订单中菜品的单价
		

			foreach($menu as $k=>$v){?>
            	<div class="order-info-dish-block" >
                    <span><?= Html::encode($v['menu_name']);?></span>
                    <span style="float:right; margin-right:30px;color:#333;">¥
					<?= Html::encode($v['menu_price']*$v['num']);?>
					</span>
                    <span style="float:right;margin-right:30px; ">¥<?= Html::encode($v['menu_price']);?>x<?= Html::encode($v['num']);?></span>
                </div>
			<?php 
				
				$arrId[] = $v['menu_id'];
				$menunum[] = $v['num'];
				$menuprice[] = $v['menu_price'];
				$strNum=implode(',',$menunum);	//菜品的数量拼接字符
				$strId=implode(',',$arrId);	//菜单的id拼接字符
				$strPrice=implode(',',$menuprice);	//菜单的id拼接字符
			}?>
            </div>
			
            <div class="order-info-fee">
            	<div class="order-info-fee-block">
                    <span>餐盒费</span>
                    <span style="float:right; margin-right:30px;color:#333;">
					<?php 
						echo '¥ '.$shop['lunchbox'];
						$lunchbox = $shop['lunchbox'];
					?></span>
                </div>
            </div>			
						
						
			
            <div class="order-info-m">
           		<?php if($choicewallet){?>
	            	<div class="order-info-m-block">
	                    <span>红包</span>
						<span style="float:right; margin-right:30px;color:#333;">¥ -1.00</span>
	                </div>
				<?php }?>
				
				<?php if($couponPrice){ ?>
				<div class="order-info-m-block">
					<span>优惠券</span>
					<span style="float:right; margin-right:30px;color:#333;">
						<?php echo "￥".$couponPrice;?>
					</span>
				</div>
				<?php }?>		
					
                <div class="order-info-m-block">
                    <span>满减优惠</span>
                    <span style="float:right; margin-right:30px;color:#333;">
					<?php 
						$sub = array();
						$ful = array();
						$subMax = array();
						if($subtract){
							foreach($subtract as $k=>$v){
								$ful[] = $v['subtract_price'];		//满e信息的数组
								$sub[] = $v['subtract_subtract'];	//满额后可减的信息数组
							}
							asort($ful);
							asort($sub);
							$min = min($ful);//满减的最小值
							$max = max($ful);//满减的最大值
							if($allPrice < $min){
								echo '不满足满减条件';
								$jian = 0;
							}else if($allPrice > $max){
								echo '减¥'.max($sub).'元';
								$jian = max($sub);
							}else{
								foreach($ful as $k=>$v)
								{
									if($allPrice>$v or $allPrice==$v){
										$subMax[] = $sub[$k];
									}
								}
								
								echo '减¥'.max($subMax).'元';
								$jian = max($subMax);
							}
						}else{
							echo "无满减政策";
						}
					?>					
					</span>
                </div>
				
	
			
				<?php if($allPrice>28){?>
	                <div class="order-info-m-block">
	                    <span>满28元免配送费</span>
	                    <span style="float:right; margin-right:30px;color:#333;">
							<?php echo '￥0';
									$distribution = 0;
							?>
						</span>
	                </div>
				<?php }else{ ?>
					<div class="order-info-m-block">
						<span>满28元免配送费</span>
						<span style="float:right; margin-right:30px;color:#333;">
						<?php 
							echo '配送费'.$shop['distribution'];
							$distribution = $shop['distribution'];?>
						</span>
					</div>
				<?php	}?>
            	
				<!--会员和公司折扣-->
				<?php if($vipinfo['name'] != '无'){?>
					<div class="order-info-m-block">
						<span>会员折扣</span>
						<span style="float:right; margin-right:30px;color:#333;">
							<?php echo $vipinfo['name'].' : <font color="#81181d">'.$vipinfo['discount'].'%</font>折优惠'?>
						</span>
	            	</div>
				<?php } ?>
				
			</div>
			<?php $allSub = $wallet+$couponPrice+$jian;?>
            <div class="order-info-total">
            	<span>总计：</span>
                <span style="float:right; margin-right:30px;color:#333;">菜品&nbsp;<font color="#81181d">¥
				<?php 
					$realPrice = sprintf($vipinfo['discount']*0.01*($allPrice-$allSub));
					if($realPrice < 0){
						echo $realPrice = 0;
					}else{
						echo $realPrice;
					}
				?></font></span>
            </div>
            <div class="order-info-comments">
            	<p>备注</p>
            	<textarea name="msg" cols=40 rows=4 style=" width:80%; margin-left:30px;" placeholder="不要辣"></textarea>
            </div>
        
	

	<!--这里是各种隐藏域  用来通过post传值 传送订单信息-->
	<input type="hidden" name="menu_num" value="<?php echo $strNum?>"/>
	<input type="hidden" name="menu_id" value="<?php echo $strId?>"/>
	<input type="hidden" name="sub" value="<?php echo (float)$jian?>"/>
	<input type='hidden' name='menu_price' value="<?php echo $strPrice?>">
	
	<!--判断是否满足免费配送的条件，并给最终的价格和 原价做出判断-->
	<input type='hidden' name='realPrice' value="<?php if($allPrice>28){echo $realPrice+$lunchbox;}else{echo $realPrice+$distribution+$lunchbox;}?>">
	<input type="hidden" name="allprice" value="<?php if($allPrice>28){echo $allPrice+$lunchbox;}else{echo $allPrice+$distribution+$lunchbox;}?>"/>
	
    <footer style="background:#fff;">
    	<span style="float:left; line-height:49px; font-size:10px; color:#707070; margin-left:30px;">已优惠¥<?php echo $allSub?></span>
		<?php 
		$start = date("H",$shop['takeaway_start_time']);
		$end = date("H",$shop['takeaway_end_time']);
		$now = date("H",time());
		?>
		<input type="hidden" name="start" id="start" value="<?php echo $start;?>"/>
		<input type="hidden" name="end" id="end" value="<?php echo $end;?>"/>
		<input type="hidden" name="now" id="now" value="<?php echo $now;?>"/>
		<button style="float:right; font-size:18px;width:89px; height:49px; background:#81181d; color:#fff; line-height:49px;" id="list1">提交订单</button>

    	
		
        <span style="float:right;line-height:49px; font-size:18px; color:#81181d; margin-right:20px;">¥
		<?php 
		if($allPrice > 28){
			echo $all = $realPrice+$lunchbox;
		
			}else{
				echo $all = $realPrice+$distribution+$lunchbox;
				
				}?></span>
			<input type="hidden" value="<?php echo $all;?>" id="all"/>
        <span style="float:right;line-height:49px; font-size:10px; color:#707070; margin-right:2px;  ">
		<?php 
			if($allPrice < 28){
				echo "5元运费|&nbsp;";
				}else{
					echo "免运费";
				}
				?>
		待支付</span>
    </footer> 
  
</form>
</div>

<script>
//	判断是否有地址信息
	$(document).on("click","#list1",function(){
		address = $("#address").val();
		start = $("#start").val()*10;
		end = $("#end").val()*10;
		now = $("#now").val()*10;

		
		if( start < now && now < end ){
			if(address == ''){
				alert("选择地址或前去添加")
				return false;			
			}else{
				return true; 
			}	
		}else{
			alert("暂时不提供外卖服务");
			return false;
		}
	
	});	
</script>

