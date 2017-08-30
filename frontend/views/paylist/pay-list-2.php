<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="content">
	
<form method="post" action="<?= yii::$app->urlManager->createUrl(['paylist/paylist2'])?>">
<input type="hidden" id="tt" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">

    	<div class="payment-info">
		<div style="text-align:center;display:none" id="callto"><font color="red">余额不足</font></div>
			<!--添加桌号-->
			<div class="payment-info-table">
            	<label>添加桌号</label>
                <input placeholder="如 03" style="line-height:30px; margin-left:20px; outline:none;" name="Addtable" id="Addtable">
            </div>
			
			<!--支付方式-->	
			<input type='hidden' name='paytype' value="1">
            <div class="payment-method">
            	<span>支付方式</span>
                <a href="#">		
				<select name="payonoff"  style="border:none;">
					<option value="online">微信支付</option>
					<option value="balance" selected>会员支付</option>
				</select></a>
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
			<input type='hidden' name='coupon' value="0">
            <div class="payment-coupon">
            	<span>宅食优惠卷</span>
                
				<?php 
				$allPrice=0;		//订单商品的实际总价格
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
            
        </div>
        	<p style=" margin-left:30px; font-size:12px; line-height:30px;">订单信息</p>
        <div class="order-info">
        	<div class="order-info-dish">
	<!--显示订单的菜品信息-->
		<?php 
		$arrId = array();	//定义数组 -- 订单中菜品的ID
		$menunum = array(); //定义数组 -- 订单中菜品的数量
		$menuprice = array(); //定义数组 -- 订单中菜品的单价
		$allPrice=0;		//订单商品的实际总价格

			foreach($menu as $k=>$v){?>
            	<div class="order-info-dish-block" >
                    <span><?= Html::encode($v['menu_name']);?></span>
                    <span style="float:right; margin-right:30px;color:#333;">¥
					<?= Html::encode($v['menu_price']*$v['num']);?>
					</span>
                    <span style="float:right;margin-right:30px; ">¥<?= Html::encode($v['menu_price']);?>x<?= Html::encode($v['num']);?></span>
                </div>
			<?php 
				$allPrice += $v['menu_price']*$v['num'];
				$arrId[] = $v['menu_id'];
				$menunum[] = $v['num'];
				$menuprice[] = $v['menu_price'];
				$strNum=implode(',',$menunum);	//菜品的数量拼接字符
				$strId=implode(',',$arrId);	//菜单的id拼接字符
				$strPrice=implode(',',$menuprice);	//菜单的id拼接字符
			}?>
			
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
				<?php echo $realPrice = sprintf($vipinfo['discount']*0.01*($allPrice-$allSub));
					if($realPrice <0 ){
						$realPrice = 0;
					}
				?>
				</font></span>
            </div>
            <div class="order-info-comments">
            	<p>备注</p>
            	<textarea name="MSG" cols=40 rows=4 style=" width:80%; margin-left:30px;" placeholder="不要辣"></textarea>
            </div>
        </div>
    

	<!--这里是各种隐藏域  用来通过post传值 传送订单信息-->
	<input type="hidden" name="menu_num" value="<?php echo $strNum?>"/>
	<input type="hidden" name="menu_id" value="<?php echo $strId?>"/>
	<input type="hidden" name="allprice" value="<?php echo $allPrice?>"/>
	<input type="hidden" name="sub" value="<?php echo (float)$jian?>"/>
	<input type='hidden' name='realPrice' value="<?php echo $realPrice?>">
	<input type='hidden' name='menu_price' value="<?php echo $strPrice?>">




    <footer style="background:#fff;">
    	<span style="float:left; line-height:49px; font-size:10px; color:#707070; margin-left:30px;">已优惠¥
		<?php echo $allSub?>
		</span>
		<?php 
		$start = date("H",$shop['eat_start_time']);
		$end = date("H",$shop['eat_end_time']);
		$now = date("H",time());
		?>		
		<input type="hidden" name="start" id="start" value="<?php echo $start;?>"/>
		<input type="hidden" name="end" id="end" value="<?php echo $end;?>"/>
		<input type="hidden" name="now" id="now" value="<?php echo $now;?>"/>		
    	<button style="float:right; font-size:18px;width:89px; height:49px; background:#81181d; color:#fff; line-height:49px;" id="list2">提交订单</button><!--堂食提交-->
		
		
        <span style="float:right;line-height:49px; font-size:18px; color:#81181d; margin-right:20px;  ">¥<?php echo $realPrice;?></span><input type="hidden" value="<?php echo $realPrice?>" id="all"/>
        <span style="float:right;line-height:49px; font-size:10px; color:#707070; margin-right:2px;  ">待支付</span>
    </footer>
 </form>
</div>
<script>
//对堂食的桌号进行验证
	$(document).on("click","#list2",function(){
		table = $("#Addtable").val();
		start = $("#start").val()*10;
		end = $("#end").val()*10;
		now = $("#now").val()*10;

		if(table < 100 && table > 0){
			if( start < now && now < end ){
				return true;
			}else{
				alert("暂时不提供服务");
				return false;
			}	
		}else{
			alert("输入桌号有误");
			return false;
		}
			
	});
</script>

