<head>
<title>宅食送-会员信息</title>
</head>
<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
?>

<style media="screen">
	.accordion-desc{
		font-style: 楷体;
		font-size: 12px;
	}
	.accordion-desc table{
		width: 100%;
		text-align: center;
		border-collapse: collapse;;
	}
	.accordion-desc td{
		border: 1px solid #000;
	}
</style>

<body>
	<div class="content">
    	<div class="user-info-top">
        	<div class="user-info-top-block1" >
            	<div style="border-radius:60%; height:43px; width:43px; margin:0 auto; ">
             <img style="border-radius:50%; height:43px; width:43px; background:#fff; margin:0 auto;"  src="<?= Html::encode($userphoto)?>">
               </div>
                <div style=" text-align:center; color:#fff; font-size:9px; line-height:30px;"><?= $experience['user_experience'] ?>/<?= Html::encode($experience['vip_experience']) ?></div>
                <section id="simple" style="width:100%; background:#fff; float:left; position:relative;">
                	<div style="background:#eb6877; width:45px; height:12px; border-radius:5px; top:-3px; left:20px; position:absolute; color:#fff; font-size:8px; line-height:12px; z-index:10; text-align:center;">注册会员</div>
                    <div style="background:#fff; width:45px; height:12px; border-radius:5px; top:-3px; left:50%; margin-left:-22px;position:absolute; color:#333; font-size:8px; line-height:12px; z-index:10; text-align:center;"><?= Html::encode($experience['vip_name']) ?></div>
                     <script src="js/nanobar.js"></script>
					<script>
												var num = "<?= $experience['user_experience'] ?>"/"<?= $experience['vip_experience'] ?>"*100;
                        var simplebar = new Nanobar({target: document.getElementById('simple')});
                        simplebar.go(num);
                        /*----50这个数字为经验条百分比------*/

                    </script>
                </section>




            </div>
            <div style="text-align:center; font-size:9px; color:#fff; bottom:0px; line-height:20px; margin-top:20px;">您当前经验值为 <?= $experience['user_experience'] ?>
            </div>
        </div>

    	<div class="accordion-container">
          <div class="user-container">
            <div class="accordion">
            	<a href="#">

                	<h4><i class=" icon-circle-blank" style=" color:#81181d; margin-right:10px;"></i>经验值<i class=" icon-angle-down" id="icon-angle" style=" color:#707070; margin-right:30px; float:right; line-height:45px; font-size:18px;"></i></h4>

                </a>
            </div>
            <div class="accordion-desc">

              <p>
								<?= $vipinfos['vip_experience_get'] ?>
              <p>

            </div>
            <div class="accordion">
            	<a href="#">
                	<h4><i class=" icon-circle-blank" style=" color:#81181d; margin-right:10px;"></i>会员等级说明<i class=" icon-angle-down" id="icon-angle" style=" color:#707070; margin-right:30px; float:right; line-height:45px; font-size:18px;"></i></h4>
                </a>
           	</div>
            <div class="accordion-desc">

              <p>
								vip等级与经验值对应如下：<br />
								<table>
									<tr>
										<td>vip等级</td>
										<td>经验值</td>
									</tr>
									<?php foreach ($vips as $key => $value): ?>
										<tr>
											<td><?= $value['vip_name'] ?></td>
											<td><?= $value['vip_experience'] ?></td>
										</tr>
									<?php endforeach; ?>
								</table>
              <p>

            </div>
            <div class="accordion">
           		<a href="#">
                	<h4><i class=" icon-circle-blank" style=" color:#81181d; margin-right:10px;"></i>特权<i class=" icon-angle-down" id="icon-angle" style=" color:#707070; margin-right:30px; float:right; line-height:45px; font-size:18px;"></i></h4>
                </a>
            </div>
            <div class="accordion-desc">

              <p>
								各vip等级特权如下：<br />
								<table>
									<tr>
										<td>vip等级</td>
										<td>折扣</td>
										<td>满减</td>
										<td>赠品</td>
									</tr>
									<?php foreach ($discount as $k => $v): ?>
										<tr>
											<td><?= $v['vip_name'] ?></td>
											<td><?= $v['vip_discount'] ?>%</td>
											<td>满<?= $v['vip_price'] ?>减<?= $v['vip_subtract'] ?></td>
											<td><?= $v['gift_name'] ?></td>
										</tr>
									<?php endforeach; ?>
								</table>
							<p>

            </div>
            <div class="accordion">
            	<a href="#">
                	<h4><i class=" icon-circle-blank" style=" color:#81181d; margin-right:10px;"></i>经验获取攻略<i class=" icon-angle-down" id="icon-angle" style=" color:#707070; margin-right:30px; float:right; line-height:45px; font-size:18px;"></i></h4>
                </a>
            </div>
            <div class="accordion-desc">

              <p>
								<?= $vipinfos['vip_experience_raiders'] ?>
              <p>

            </div>


          </div>
          <!-- end of container -->
        </div>

    </div>

<script src='js/jquery.min.js'></script>
<script src="js/index.js"></script>

    <footer>
            <a style="border-right:1px solid #fff;" href="<?= Url::to(['index/index'])?>"><img src="img/icon-diancan.png" >点餐</a>
            <a style="border-right:1px solid #fff;" href="<?= Url::to(['order/index'])?>"><img src="img/icon-dingdan.png"  >订单</a>
            <a  style="border-right:1px solid #fff;" href="<?= Url::to(['user/index'])?>"><img src="img/icon-user.png" >会员</a>
    </footer>
</body>
</html>
