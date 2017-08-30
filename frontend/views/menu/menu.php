<script type="text/javascript">
$(document).ready(function(){
	$('#container').containerNav();
	$('#transformers').containerNav({items:['autobots','decepticons'], debug: true, height: '300', arrows: false});
	//背景跟随变化
	nav0 = $(".nav:eq(0)").offset().top;
	nav1 = $(".nav:eq(1)").offset().top;
	nav2 = $(".nav:eq(2)").offset().top;	
	$(".menu").scroll(function(){
        Top_height = $(this).scrollTop()+200; 
		    
        if(Top_height < nav1){      
			$(".navmenu").removeClass("active");
			$(".navmenu:eq(0)").addClass("active");	
			$('.title').css('position','static');
			$('.title:eq(0)').css('position','fixed');			
			$('.title:eq(0)').css('top',nav0);			
        }else if(Top_height > nav1 || Top_height==nav1 || Top_height < nav2 ){
			$(".navmenu").removeClass("active");
			$(".navmenu:eq(1)").addClass("active");
			$('.title').css('position','static');
			$('.title:eq(1)').css('position','fixed');			
			$('.title:eq(1)').css('top',nav0);
        }if(Top_height > nav2 || Top_height==nav2){
			$(".navmenu").removeClass("active");
			$(".navmenu:eq(2)").addClass("active");	
			$('.title').css('position','static');
			$('.title:eq(2)').css('position','fixed');				
			$('.title:eq(2)').css('top',nav0);
        }
	});
	var mySwiper = new Swiper('.swiper-container',{
	    pagination: '.swiper-pagination',//控制点
	    loop:true,
	    grabCursor: true,
	    paginationClickable: true,
	    autoplay:true,
	    speed:3000,
	    autoplayDisableOnInteraction:false,           //滑动后轮播图正常运行
	 })
});
</script>
<title>宅食送－菜单</title>

</head>

<body>

	<header>	
    	<div class="header-title">
        	<span>外卖－恒通商务园店</span>
            
        </div>
    </header>
    <div class="content">
    	<div class="banner">
    		<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<img src="<?php yii::$app->request->baseUrl?>img/3.jpg" width="100%" height="100%">
					</div>
					<div class="swiper-slide">
						<img src="<?php yii::$app->request->baseUrl?>img/3.jpg" width="100%" height="100%">
					</div>
					<div class="swiper-slide">
						<img src="<?php yii::$app->request->baseUrl?>img/3.jpg" width="100%" height="100%">
					</div>
					
				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
				</div>
        </div>
        <div id="container">
        
        	<div class="menu">
            	<ul>
                	<li class="nav" id="热卖">
                		<a name="热卖" class="title"><span>热卖</span></a>  
                		
                        <ul>
                        	<li>
                            	<div class="menu-block" >
                                
                                	<img src="<?php yii::$app->request->baseUrl?>img/images/宅食送页面设计_03.jpg" width="100%" height="100%" style="display:">
                                    <div class="menu-details">
                                    	<div class="menu-details-left">
                                            <div class="menu-details-title">
                                            香菇鸡肉套餐<font size="-3">（主菜＋米饭＋小菜）</font>
                                            </div>
                                            <div class="menu-details-category">
                                            汤德 川味 
                                            </div>
                                            <div class="menu-details-content">
                                            香菇素有"山珍之王"之称，是高蛋白、低脂肪的营养
保健食品。味道鲜美，香气沁人，营养丰富……
                                            </div>
                                        </div>
                                    	<div class="menu-details-right">
                                            <span class="menu-details-price">¥26</span>
                                            <div class="num_box" style="color:#fff;"><a class="J_jian"><i class="icon-minus-sign"></i></a><label><input type="text" class="num" value="0" disabled="disabled" style="width:30px;background-color:transparent; color:#fff; border:none; font-size:22px; margin:0 10px; text-align:center;"/></label><a class="J_jia"><i class="icon-plus-sign"></i></a></div>  
											
                                                
                                            
                                    	</div>
                                    </div>
                                    
                                </div>
                            </li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                        </ul>
                    </li>
                    <li class="nav" id="新品">
                    	<a name="新品" class="title"><span>新品</span></a>
                    	
                        <ul>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                        </ul>
                    </li>
                    <li  class="nav" id="汤德">
                    	<a name="汤德" class="title"  ><span>汤德</span></a>   
                    	
                        <ul>
                            <li style="border-top:1px solid #C4C4C4">
                            	<a href="/" ><img src="<?php yii::$app->request->baseUrl?>img/11.jpg" width="110" height="111" style="float:left;">
                                    <div class="menu-content">
                                        <div class="chief-name">
                                            汤德
                                        </div>
                                        <div class="chief-cate">
                                            川味私房菜
                                        </div>
                                        <div class="chief-details">
                                            菜根香、陶然居厨师长，川人百味行政总厨。<br>
                                            2013年全国百强厨师长全能冠军。
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                            <li><a href="/"><img src="<?php yii::$app->request->baseUrl?>img/5.jpg" width="100%" height="100%"></a></li>
                        </ul>
                    </li>
                </ul>              
            </div>
            
        	<script type="text/javascript">  
                                             $(document).ready(function(){  
                                           var add,reduce,num,num_txt;  
                                           add=$(".J_jia");//添加数量  
                                           reduce=$(".J_jian");//减少数量  
                                           num="";//数量初始值  
                                           num_txt=$(".num");//接受数量的文本框     
                                           //var num_val=num_txt.val();//给文本框附上初始值  
                                             
                                           /*添加数量的方法*/  
                                           add.click(function(){  
                                             num = $(".num").val();      
                                             num++;  
                                             num_txt.val(num);  
                                             //ajax代码可以放这里传递到数据库实时改变总价  
                                            });  
                                              
                                           /*减少数量的方法*/   
                                           reduce.click(function(){  
                                            //如果文本框的值大于0才执行减去方法  
                                                num = $(".num").val();  
                                             if(num >0){  
                                              //并且当文本框的值为1的时候，减去后文本框直接清空值，不显示0  
                                              if(num==0)  
                                              { num--;  
                                               num_txt.val("1");  
                                              }  
                                              //否则就执行减减方法  
                                              else  
                                              {  
                                               num--;  
                                               num_txt.val(num);  
                                              }  
                                            
                                             }  
                                            });  
                                          })  
                                            </script>  
            
        </div>
        
    </div>
    
    <footer>
    	
        <a style="float:right; font-size:18px;width:89px; height:49px; background:#dcdcdc; color:#81181d; line-height:49px;">结算</a>
    </footer>
</body>
</html>
