<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
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
<link rel="stylesheet" href="<?php yii::$app->request->baseUrl;?>css/style.css" media="all">
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=oWIHQyc9uLNLXsKuLSGGUU44"></script>
<title>宅食送</title>
<script type="text/javascript">
ranking();
function ranking(){
	//获取当前坐标
	var geolocation = new BMap.Geolocation();
	geolocation.getCurrentPosition(function(r){
		if(this.getStatus() == BMAP_STATUS_SUCCESS){
			var map = new BMap.Map();
			var pointA = new BMap.Point(r.point.lng+','+r.point.lat);  // 创建点坐标A--当前位置
			var pointB = new BMap.Point($(".shop-list").attr('coordy'),$(".shop-list").attr('coordz'));  // 创建点坐标B--门店坐标
			for(var i=0;i<$(".shop-list").length;i++){
				var pointB = new BMap.Point($(".shop-list").eq(i).attr('coordy'),$(".shop-list").eq(i).attr('coordz'));  // 创建点坐标B--门店坐标
				//将长度给予各class的name属性
				$(".shop-list").eq(i).attr("name",(map.getDistance(pointA,pointB)).toFixed(2)*100);
			}
			//排序
			var arr = new Array();
			$(".shop-list").each(function(){
        arr[arr.length] = $(this).attr("name");
      });
			arr2 = arr.sort(function(x,y){return parseInt(y)-parseInt(x);});
			//arr2=arr.sort();
      for(var i=arr2.length-1;i>=0;i--){
          $(".content").append($(".shop-list[name="+arr2[i]+"]"));
      }
			//$("body").show();
		}
		else {
			alert('failed'+this.getStatus());
		}
	},{enableHighAccuracy: true})
}
</script>
</head>

<body>
	<header>
    	<div class="header-title">
        	<span>刷新最近门店</span>

        </div>
    </header>
    <div class="content">
			<?php foreach($shops as $v) : ?>
    	<div class="shop-list" coordy="<?= Html::encode($v['shop_y']) ?>" coordx="<?= Html::encode($v['shop_x']) ?>">
        	<ul>
            	<li>
                	<span class="title"><?= Html::encode($v['shop_name']) ?><a>送餐范围</a></span>
                  <span class="details"><?= Html::encode($v['shop_address']) ?><br>电话：<?= Html::encode($v['shop_tel']) ?></span>
                  <span class="deliver-w">
                  	<a>sdsa</a>
                  </span>
              </li>
          </ul>
      </div>
		<?php endforeach ; ?>
    </div>

    <footer>
    	<a style="background:#510c0f"  href="<?= Url::to(['shop/index'])?>" >点餐</a>
        <a style="border-right:1px solid #fff;" href="<?= Url::to(['order/index'])?>" >订单</a>
        <a style="border-right:1px solid #fff;" href="<?= Url::to(['user/index'])?>">会员</a>
    </footer>
</body>

</html>
