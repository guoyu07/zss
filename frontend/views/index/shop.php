<?php 
    use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=iC1MaVT5vfdCg7EDZXyinAp1"></script>
	<title>宅食送--菜单</title>
</head>
<body>
	<div id="allmap"></div>
	<?php foreach ($shop as $sk=>$sv):?>
		<input type='hidden' class="hidden" shop_id="<?= Html::encode($sv['shop_id']); ?>" shop_x="<?= Html::encode($sv['shop_x']); ?>" shop_y="<?= Html::encode($sv['shop_y']); ?>"/>
	<?php endforeach;?>
</body>
</html>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>

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

	        Pos(longitude,latitude);
	    },

	    cancel: function (res) {
	        alert('用户拒绝授权获取地理位置');
	    }
	});
});

function Perison(distance,shopid){
	this.distance = distance;
	this.shopid = shopid;
}

function Pos(longitude,latitude){
	
	var hidden = $('.hidden');
	var arr = [];
	shop = '';
	k = 0 ;
	
	for(i=0;i<eval(hidden).length;i++){
		map = new BMap.Map("allmap");
		shop_x = hidden.eq(i).attr('shop_x');
		shop_y = hidden.eq(i).attr('shop_y');
		
		shop_id = hidden.eq(i).attr('shop_id');

		pointA = new BMap.Point(longitude,latitude);  // 创建点坐标A
		pointB = new BMap.Point(shop_y,shop_x);  // 创建点坐标B

		distance = (map.getDistance(pointA,pointB)).toFixed(2);
		distance = parseInt(distance);
		if(distance < 2000){
			arr.push(new Perison(distance,shop_id));
		}
	}
	
	shop_sort = arr.sort(function(a,b){
        return a.distance-b.distance});
    for(i=0;i<shop_sort.length;i++){
		shop += ','+shop_sort[i]['shopid'];
    }
    shop_last = shop.substr(1);
	location.href="index.php?r=index/run&shop="+shop_last;
}



function size(arr){ 
	var j = arr[0][0];
	var shop = '';
    for(i=1;i<arr.length;i++){
    	temp = parseFloat(arr[i][0]);
    	if(temp < j){
    		j = temp;
    		shop += ','+arr[i][1];
        }
    }
    return shop;
}  
</script> 