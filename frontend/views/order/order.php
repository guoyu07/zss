<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>

<title>宅食送－订单</title>
</head>

<body>
	
    <div class="content">

    	<!--- Demo --->
		<?php foreach($models as $key=>$val): ?>
    	<div class="order-list">
        	<ul>
            	<li>
                	<div class="title-block">
                    	<span class="title"><?= HtmlPurifier::process($val['shop_name']) ?>-
								<?php if($val['delivery_type']==1){ echo "堂食"; }elseif($val['delivery_type']==2){ echo "自提"; }elseif($val['delivery_type']==3){ echo "外卖"; } ?></span>
                        <div style="border-bottom:1px solid #e4e4e4;">
                            <span class="order-num">订单号：<?= HtmlPurifier::process($val['order_sn']) ?></span>
                            <span class="order-status">
								<?= HtmlPurifier::process($val['line']) ?>
							</span>
                        </div>
                    </div>
					<a href="<?= Url::to(['order/order-list'])."&id=".$val['order_id'] ?>">
                    <div class="time-block">
                    	<?= HtmlPurifier::process(date("H:i:s",$val['created_at'])) ?>
                    </div>
                    <div class="order-detail-block">
						<?php if($val['meal_number']): ?>
							<div class="order-detail-block-left">
								<span style="font-size:12px; display:block;">取餐号</span>
								<span style="font-size:30px;"><?= HtmlPurifier::process($val['meal_number']) ?></span>
							</div>
						<?php endif; ?>
                    	
						<?php if($val['seat_number']): ?>
						 <div class="order-detail-block-left">
                        	<span style="font-size:12px;display:block;">桌号</span>
                            <span style="font-size:30px;"><?= HtmlPurifier::process($val['seat_number']) ?></span>
                        </div>
						<?php endif; ?>
                       
                        <div class="order-detail-block-right">
                        	<span style="font-size:12px;display:block; visibility:hidden;">桌号</span>
                            <span style="font-size:30px;">¥<?= HtmlPurifier::process($val['order_payment']) ?></span>
                        </div>
                    </div>
					</a>
                    <div class="order-button-block">
					<?php if($val['order_status']!=0): ?>

							<a href="javascript:void(0)" class="button-hongbao" onclick="weixinSendAppMessage()"  id="<?= HtmlPurifier::process($val['order_id']) ?>" />发红包</a>
					
					<?php endif; ?>            
					
					<?php if($val['order_status']==0): ?>
							   <a href="<?= Url::to(['paylist/accounts','order_sn'=>$val['order_sn']])?>" class="button-zailai">买单</a>
					<?php else: ?>
								<a href="<?= Url::to(['index/index'])?>" class="button-zailai" >再来一单</a> 
					<?php endif; ?>                   
                    </div>
                </li>
            </ul>
        </div>
		<?php endforeach; ?>
        <!- Demo  end -->
        	
      
    </div>

    <footer>
    	<a style="border-right:1px solid #fff;" href="<?= Url::to(['index/index'])?>"><img src="img/icon-diancan.png" >点餐</a>
        <a style="border-right:1px solid #fff;" href="<?= Url::to(['order/index'])?>&userid=<?= $info?>"><img src="img/icon-dingdan.png"  >订单</a>
        <a  style="border-right:#510c0f;" href="<?= Url::to(['user/index'])?>"><img src="img/icon-user.png" >会员</a>
    </footer>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<!-- <script src="http://demo.open.weixin.qq.com/jssdk/js/api-6.1.js?ts=1420774989"> </script>
 -->

<script type="text/javascript">
/*
function weixinSendAppMessage(){
	WeixinJSBridge.invoke('sendAppMessage',{
	"appid":'wxa30af7dbdde547b8',
	"img_url":'http://www.wujiaweb.com/file/hb.jpg',
	"img_width":"400",
	"img_height":"400",
	"link":'http://www.wujiaweb.com/web',
	"desc":'分享才是真爱··',
	"title": '好基友,送福利',
	});
}
*/


order_sn = "";
var info = '<?php echo $info?>'
$(document).on("click",".button-hongbao",function(){

	alert("红包已经准备好,点击右上角菜单分享给好友！")
//通过config接口注入权限验证配置
wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
           'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',	
		
        'openCard'
          ]
    });


					
   wx.ready(function () {
wx.onMenuShareAppMessage({
          title: '好基友,送福利',
          desc: '关注  北京让我们见个面  即获红包',
			link: '#', 
            imgUrl: 'http://www.wujiaweb.com/file/hb2.jpg',
          success: function (res) {
             alert('已分享');
          },
          cancel: function (res) {
             alert('已取消');
          },
          fail: function (res) {
             alert("分享失败");
          }
        });

   })

})



</script>
</body>
</html>
