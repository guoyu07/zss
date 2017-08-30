<?php
use frontend\adress\JSSDK;
$jssdk = new JSSDK("wxa30af7dbdde547b8", "532f76adb7e282990a4db46560fd5683");
$signPackage = $jssdk->GetSignPackage();
?>
1211
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script type="text/javascript">
wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
        // 所有要调用的 API 都要加到这个列表中
        'checkJsApi',
        'openLocation',
        'getLocation'
      ]
});
wx.ready(function () {
wx.getLocation({
    success: function (res) {
        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
        var speed = res.speed; // 速度，以米/每秒计
        var accuracy = res.accuracy; // 位置精度
		alert("维度"+longitude+";经度:"+latitude);
    },
    cancel: function (res) {
        alert('用户拒绝授权获取地理位置');
    }
});

});
	  wx.checkJsApi({
    jsApiList: [
        'getLocation'
    ],
    success: function (res) {
         alert(JSON.stringify(res));
        // alert(JSON.stringify(res.checkResult.getLocation));
        if (res.checkResult.getLocation == false) {
            alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
            return;
        }
    }
});
</script>