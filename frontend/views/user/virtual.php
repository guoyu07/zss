<?php
use yii\helpers\Html;
?>
<title>宅食送－积分</title>
<style type="text/css">
.dowebok ul{list-style-type: none;}
.dowebok li{display: inline-block;}
.dowebok li{margin: 10px 0;}
input.labelauty + label{font:12px "Microsoft Yahei";}
</style>
<script type="text/javascript" src="<?php yii::$app->request->baseUrl?>js/iscroll.js"></script>

<body>
	<div class="content">
    	<div class="yue-top">
        	<h2>积分</h2>
            <h1><span><?=Html::encode($virtual_now)?></span></h1>

        </div>
        <p style="margin-left:30px; padding:5px 0;">消费记录</p>
        <!-- <div class="yue-record" id="wrapper"> -->

					<div class="yue-record" id="wrapper">
        	<ul>
            	<li>
                	<span>消费门店</span>
                    <span>消费时间</span>
                    <span>消费金额</span>
                    <span>获取积分</span>
                </li>

								<?php foreach ($virtual as $key => $value): ?>
									<li>
										<?php foreach ($value as $k => $v): ?>
											<span><?=Html::encode($v)?></span>
										<?php endforeach; ?>
	                </li>
								<?php endforeach; ?>
            </ul>
					</div>

					<div id="scroller">
						<div id="pullDown">
								<span class="pullDownIcon"></span><span class="pullDownLabel"></span>
						</div>
						<div id="pullUp">
								<span class="pullUpIcon"></span><span class="pullUpLabel"></span>
						</div>
					</div>
    </div>



		<!-- <div id="wrapper">
		    <div id="scroller">
		        <div id="pullDown">
		            <span class="pullDownIcon"></span><span class="pullDownLabel">Pull down to refresh...</span>
		        </div>
		        <ul id="thelist">
		        </ul>
		        <div id="pullUp">
		            <span class="pullUpIcon"></span><span class="pullUpLabel">Pull up to refresh...</span>
		        </div>
		    </div>
		</div> -->




<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
function loaded() {
    pullDownEl = document.getElementById('pullDown');
    pullDownOffset = pullDownEl.offsetHeight;
    pullUpEl = document.getElementById('pullUp');
    pullUpOffset = pullUpEl.offsetHeight;

    myScroll = new iScroll('wrapper', {
        useTransition: true,
        topOffset: pullDownOffset,
        onRefresh: function () {
            if (pullDownEl.className.match('loading')) {
                pullDownEl.className = '';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新';
            } else if (pullUpEl.className.match('loading')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多';
            }
        },
        onScrollMove: function () {
            if (this.y > 5 && !pullDownEl.className.match('flip')) {
                pullDownEl.className = 'flip';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '松开刷新';
                this.minScrollY = 0;
            } else if (this.y < 5 && pullDownEl.className.match('flip')) {
                pullDownEl.className = '';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新';
                this.minScrollY = -pullDownOffset;
            } else if (this.y < (this.maxScrollY - 10) && !pullUpEl.className.match('flip')) {
                pullUpEl.className = 'flip';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '松开刷新';
                this.maxScrollY = this.maxScrollY;
            } else if (this.y > (this.maxScrollY + 10) && pullUpEl.className.match('flip')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多';
                this.maxScrollY = pullUpOffset;
            }
        },
        onScrollEnd: function () {
            if (pullDownEl.className.match('flip')) {
                pullDownEl.className = 'loading';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中';
                pullDownAction();   // Execute custom function (ajax call?)
            } else if (pullUpEl.className.match('flip')) {
                pullUpEl.className = 'loading';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中';
                pullUpAction(); // Execute custom function (ajax call?)
            }
        }
    });

    //setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
}
//document.addEventListener('touchmove', function (e) {  e.preventDefault(); }, false);
//document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);


//准备就绪后
//就应该执行了
function pullDownAction () { // 下拉刷新
    window.location.reload();
}
var i = 2; //初始化页码为2
function pullUpAction () { //上拉加载更多
    var page = i++; // 每上拉一次页码加一次 （就比如下一页下一页）
    Ajax(page); // 运行ajax 把2传过去告诉后台我上拉一次后台要加一页数据（当然 这个具体传什么还得跟后台配合）
    myScroll.refresh();// <-- Simulate network congestion, remove setTimeout from production!
}
function Ajax(page){ // ajax后台交互
    $.ajax({
        type : "post",
        dataType : "JSON",
        url : "/installerAjax", // 你请求的地址
        data : {
            'page': page  // 传过去的页码
        },
        success : function(data){
            data =  eval(data.clientList);
            	if(data.length){ // 如果后台传过来有数据执行如下操作 ， 没有就执行else 告诉用户没有更多内容呢
                        //加载数据。。。
              }else{
                $('.pullUpLabel').html('亲，没有更多内容了！');
            	}

        },
        error : function(){

        }
    });
}
</script>
</body>
</html>
