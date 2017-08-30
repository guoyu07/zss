<?php 
use yii\helpers\Html;
use yii\helpers\VarDumper;


?>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
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
    <header style="position:fixed; z-index:10;">    
        <div class="header-title">
            <span><?= Html::encode($shop['name']); ?></span>
        </div>
    </header>
    <div class="content">
        <div class="banner" >
            <div class="swiper-container">
                <div class="swiper-wrapper">
                <?php foreach($carousel as $ck=>$cv):?>
                <div class="swiper-slide">
                        <img src="<?php echo "http://www.profect.site:82/".$cv['carousel_wx'];?>">
                    </div>
                <?php endforeach;?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                </div>
        </div>
        <script>

        
            $(function() {
                var AllHet = $(window).height();
                var mainHet = $('.floatCtro').height();
                var fixedTop = (AllHet - mainHet) / 2
                
                $('.series').click(function() {
                    $('.series').removeClass('cur');

                    $('.series').each(function(index, element){
                       var src = $('#imgr'+$(element).attr('id')).val();
                       $(element).find('img').attr({'src': src})
                    });

                    $(this).addClass("cur");
                    var ind = $(this).attr('id');
                    var img = $('#imgw'+ind).val();
                    $(this).children('img').attr({'src':img});

                    var topVal = $('#float' + ind).offset().top - 167;
                    $('body,html').animate({scrollTop: topVal}, 1000);
                    
                    
                })
                $('div.floatCtro a').click(function() {
                    $('body,html').animate({scrollTop: 0}, 1000)
                })
                $(window).scroll(scrolls)
                scrolls()
                function scrolls() {
                   
                    var fixRight = $('div.floatCtro p');
                    var blackTop = $('div.floatCtro a')
                    var sTop = $(window).scrollTop();
                    

                    for(i=1;i<=$('.float').length;i++){
                        var f = $('#float'+i).offset().top;
                        if (i <= 2) {
                            if (sTop <= f - 100) {
                                blackTop.fadeOut(300).css('display', 'none')
                            }
                            else {
                                blackTop.fadeIn(300).css('display', 'block')
                            }
                        };
                        if (sTop >= f - 167) {
                            fixRight.eq(i-1).addClass('cur').siblings().removeClass('cur');
                            $('.series').each(function(index, element){
                               var src = $('#imgr'+$(element).attr('id')).val();
                               $(element).find('img').attr({'src': src})
                            });
                            var ind = fixRight.eq(i-1).attr('id');
                            var img = $('#imgw'+ind).val();
                            fixRight.eq(i-1).children('img').attr({'src':img});
                        }
                    }
                    
                    

                }
            })
        </script>
        <div id="container" class="container" >
        
            <div class="menu">
                <?php foreach($series_info as $sk=>$sv):?>
                    
                        <div id="float<?= Html::encode((int)($sk+1))?>" class="cur float">
                        
                            <a name="<?= Html::encode($sv['series_name'])?>" class="title" style=" display:block;" ><span><?= Html::encode($sv['series_name'])?></span></a>
                            <?php if ($sv['series_img3'] && $sv['series_img3'] != 'upload1.jpg') { ?>
                                <div style="clear:both"></div>
                                <div class="mingchu">
                                    <img src="http://www.profect.site:82/add/imges/<?php echo $sv['series_img3']?>" height="115px" width="110px" class="left">
                                    <div class="right">
                                        <p><?= Html::encode($sv['series_name'])?></p>
                                        <p style="font-size:12px;"><?= Html::encode($sv['series_name2'])?></p>
                                        <p style="font-size:12px; margin-top:10px; line-height:15px;word-break:normal;"><?= Html::encode($sv['series_desc'])?></p>
                                    </div>
                                </div>
                            <?php }?>
                            
                            
                            <ul>
                            <?php foreach ($sv['series_data'] as $dk=>$dv):?>
                                <li class="menu-item" data-id="<?= Html::encode($dv['menu_id']);?>">
                                  <div class="menu-block" >
                                      <img src="http://www.profect.site:82/add/menu/<?php echo $dv['image_wx']?>" width="100%" height="100%" >
                                      <a class="detail_show" o='pop' style=" width:100%; height:120px; position:absolute; top:0; left:0;" href="javascript:void(1);">
                                        </a>
                                        <div class="menu-details">
                                          <div class="menu-details-left">
                                                <div class="menu-details-title">
                                                <?= Html::encode($dv['menu_name']) ?></div>
                                               <div class="menu-details-category">
                                               <?= Html::encode($dv['series_name']) ?>
                                                </div>  
                                                <div class="menu-details-content">
                                                <?= Html::encode($dv['menu_introduce']) ?>
                                                </div>
                                            </div>
                                          <div class="menu-details-right">
                                                <span class="menu-details-price" data-value="<?= Html::encode($dv['menu_price']) ?>">¥<?= Html::encode($dv['menu_price']) ?></span>
                                                <div class="num_box" style="color:#fff;">
                                                <a class="J_jian"><i class="icon-minus-sign"></i></a>
                                                <label><input type="text" class="num" value="0" val="<?= Html::encode($dv['menu_id']);?>"  data-price="<?= Html::encode($dv['menu_price']) ?>" data-stock="<?= Html::encode($dv['menu_stock']); ?>" disabled="disabled" style="width:30px;background-color:transparent; color:#fff; border:none; font-size:22px; margin:0 10px; text-align:center;"/></label>
                                                <a class="J_jia"><i class="icon-plus-sign"></i></a>
                                                <input type="hidden" class="stock" value="<?= Html::encode($dv['menu_stock']); ?>"/>
                                                <input type="hidden" class="series_id" value="<?= Html::encode($dv['series_id']); ?>">
                                                </div>  
                                          </div>
                                        </div>
                                        
                                    </div>
                                </li>
                                 <?php endforeach;?>   
                            </ul>
              
                        </div>
                  
                <?php endforeach;?>       
                    </div>
            
            
            <div class="floatCtro">
                        <?php foreach($series_info as $sk=>$sv):?>
                            <p class="series" id="<?= Html::encode((int)($sk+1))?>">
                                <img id="imgs<?= Html::encode((int)($sk+1))?>" src="http://www.profect.site:82/add/imges/<?= Html::encode($sv['series_img2'])?>">
                                <input id="imgw<?= Html::encode((int)($sk+1))?>" type="hidden" value="http://www.profect.site:82/add/imges/<?= Html::encode($sv['series_img1'])?>" />
                                <input id="imgr<?= Html::encode((int)($sk+1))?>" type="hidden" value="http://www.profect.site:82/add/imges/<?= Html::encode($sv['series_img2'])?>" />
                                <?= Html::encode($sv['series_name'])?>
                            </p>
                        <?php endforeach;?>
                        <a>
                            <font style="width:60px; height:1px; display:block"></font>
                            <span>返回顶部</span>
                        </a>
            </div>
        </div>
        <?php if(!($shop['name'] == '默认门店')){?>
<script type="text/javascript">
    
    $(document).ready(function(){
        all = getPrice(0);
        if(all < 0){
            $.cookie('all','null')
        }else{
            all = $.cookie('all');
        }
        if (all == 'null' || all == '') {
            $('#allprice').text('0') 
        }else{
            $('#allprice').text(all) 
        };
        
    });

    var ids = '';
    $('.detail_show').click(function(){
            var menu_id = $(this).parents('.menu-item').data('id');
            var detail_img = $(this).prev().attr('src') //详情图片
            var detail_name = $(this).next().children().eq(0).children().eq(0).text();//详情菜品名称
            var detail_series = $(this).next().children().eq(0).children().eq(1).text();//详情菜品分类
            var detail_desc = $(this).next().children().eq(0).children().eq(2).text();//详情菜品描述
            
            var detail_1 = $(this).next().children().eq(1).children().eq(0).data('value');//详情菜品单价
            var detail_num = $(this).next().children().eq(1).children().eq(1).children().eq(1).children(".num").val();//详情菜品数量
            var stock_num = $(this).next().children().eq(1).children().eq(1).children().eq(1).next().next().val();
            event.stopPropagation?event.stopPropagation():event.cancelBubble=true;
            var o = document.getElementById('pop');
            ids = 'pop';
            getPrice(2);
                var str = '<div class="menu-item menu-pop" id="pop" data-id="'+menu_id+'"><div class="menu-pop-top"></div><div class="menu-pop-img"><img src='+detail_img+' width="100%" height="100%"></div><div class="menu-pop-content"><p class="p1">'+detail_name+'<font style="font-size:9px;">(主菜＋配菜＋米饭)</font></p><p class="p2">'+detail_series+'川味</p><p class="p2">月售:&nbsp;&nbsp;1231份</p><div class="price"><span>¥'+detail_1+'</span><div class="count"><a class="J_jian"><i class="icon-minus-sign"></i></a><label><input type="text" class="num" value="'+detail_num+'" data-price="'+detail_1+'" data-stock="'+stock_num+'" disabled="disabled" style="width:30px;background-color:transparent; color:#81181d; border:none; font-size:22px; margin:0 10px; text-align:center;"/></label><a class="J_jia"><i class="icon-plus-sign"></i></a><input type="hidden" class="stock" value="'+stock_num+'"></div></div></div><div class="details"><div style="margin-top:10px; border-top:1px solid #e5e5e5;"></div><span >菜品介绍</span><p>'+detail_desc+'</p></div></div>';
            
            $('#fade').next().html(str);
            $('#fade').next().show();
            $('#footer').show();
            //因为页面很长，有纵向滚动条，先让页面滚动到最顶端，然后禁止滑动事件，这样可以使遮罩层锁住整个屏幕  
            var heights = document.body.scrollHeight;
            var css='<style class="css">html,body {position:absolute;width:100%;height:'+heights+'px;top:0;left:0;overflow:hidden}</style>';
            $('head').append(css);
            $('#footer').css('z-index','98')
            //$('.content').css('overflow','hidden')
        fade.style.display='block';

                
            
    });

    

    function show(evt,o){
        
        var ob = document.getElementById(o);
        ids = o;
        getPrice(2);
        cart = $.cookie('cart');
        if(!cart || cart == 'null'){cart = '<div style=\"text-align:center;vertical-align: middle;color:#ccc;font-size:20px;line-height:30px;\">购物车暂无数据</div>';}
        str = '<div class="menu-cart" id="cart" ><div class="menu-cart-top"><span>已选餐品</span><a onclick="CartClear()">清空购物车</a></div>'+cart+'</div>';

        $('#fade').next().html(str)
        $('#fade').next().show();
        $('#footer').show();
        
        fade.style.display='block';
        //因为页面很长，有纵向滚动条，先让页面滚动到最顶端，然后禁止滑动事件，这样可以使遮罩层锁住整个屏幕  
        var heights = document.body.scrollHeight;
        var css='<style class="css">html,body {position:absolute;width:100%;height:'+heights+'px;top:0;left:0;overflow:hidden}</style>';
        $('head').append(css);



        $('.order-block').css('width','100%');
        $('.order-block').css('clear','both');
        $('.order-block').css('margin-left','10px');
        $('.order-block').css('line-height','40px');
        $('.span-name').css('float','left');
        $('.span-name').css('margin-left','10px');
        $('.count').css('float','right');
        $('.count').css('color','#81181d');
        $('.count').css('margin-right','20px');
        $('.span-price').css('float','right');
        $('.span-price').css('display','block');
        $('.span-price').css('margin-right','40px');
        
        
    } 

    function CartClear(){
        all = getPrice(0);
        all = parseFloat(all);
        // if(all > 0){
            $.get('index.php?r=index/cartclear',function(status){
                    $.cookie("cart",null); 
                    $.cookie("all",null);
                    $('.order-block').html('<div style=\"text-align:center;vertical-align: middle;color:#ccc;font-size:20px;line-height:30px;\">购物车暂无数据</div>');
                    $('.num').val('0');
                    $('#allprice').text(0)
            });
        // }
    }

    function getCookie(name) {
         var arr,reg=name;
          if(arr=document.cookie.match(reg)) return(arr[2]); else
        return null; }

    function hide(o){ 
        //$('#'+o).hide();
        //var ob = document.getElementById(o);
        ids = o;
        $('#'+o).hide();
        $('#fade').hide();
        $('.menu-cart').hide();
        $('.css').remove(); 
        $('#footer').css('z-index','101')
        $('.content').css('overflow','visiable')
    }
    $('.content').click(function(){hide(ids);});
    $(document).on('click','#fade',function(){
        // $('#fade').hide();
        // $('.menu-cart').hide();
        hide(ids);
    });
</script> 
<script type="text/javascript">  
                var menu_str = '';   
                 function paylist(){
                    var retu = getPrice(1);
                    if(retu > 0){
                        // $.cookie('all',retu);
                        location.href="index.php?r=paylist/index&&all="+retu+"&&menu="+menu_str+"&&shop_id="+<?php echo $shop_id;?>;
                    }else{
                        alert('请先选择菜品');
                    }
                 }
                 
                 function getPrice(status){
                     var numObj = $('.menu-item:not(.menu-pop) .num');
                     var title = $('.menu-details-title');
                     // var menu_detail_price = $('.menu-cart .menu-item .span-price').data('price');
                     var all = 0;
                     var num = 0;
                     var cart = '';
                     numlen = numObj.length;
                     for(i=0;i<numlen;i++){
                         numval = numObj.eq(i).val();//获取商品选购数量
                         if(!numval){
                         	numval = 0;
                         }
                        if(numval > 0){//如果商品数量大于0的话
                            // each = menu_detail_price.eq(i).text().substr(1);
                            menu_id = numObj.eq(i).attr('val');//获取商品ID
                            each  = numObj.eq(i).data('price');
                            stock_num = numObj.eq(i).data('stock');
                            if(!each){
                            	each = 0;
                            }

                            if(status == 2 && each && menu_id){
                                menu_name = title.eq(i).text();//获取商品名称
                                cart += '<div class="menu-item order-block" data-id="'+menu_id+'"><span class="span-name">'+menu_name+'</span><div  class="count"><a class="J_jian"><i class="icon-minus-sign"></i></a><label><input type="text" class="num" value="'+numval+'" disabled="disabled" style="width:30px;background-color:transparent; color:#81181d; border:none; font-size:22px; margin:0 10px; text-align:center;"/></label><a class="J_jia"><i class="icon-plus-sign"></i></a><input type="hidden" class="stock" value="'+stock_num+'"></div><span class="span-price" data-value="'+each+'">¥'+each+'</span></div>';

                                $.cookie('cart',cart);
                            }
                            // if(status == 0 || status ==1){
                                all += parseFloat(numval)*parseFloat(each);
                            // };
                            if(status == 1){
                                series_id = $('.series_id').eq(i).val();
                                menu_str += "menu="+menu_id;
                                menu_str += ',num=' +numval;
                                menu_str += ',each=' +each;
                                menu_str += ',series_id='+series_id;
                                menu_str += ' ';
                            }
                        }
                     }
                     
                     all = all.toFixed(2);
                     return all;
                 }

                 $(document).ready(function(){
                     
                     /*
                        * 份数增加
                      */
                        $(document).on('click','.J_jia',function(){
                            var menu_id = $(this).parents('.menu-item').data('id');
                            var obj = $(this).prev().children();
                            var stock = parseFloat($(this).next().val());
                            if(!stock){
                            	stock = 0;
                            }
                            var menu_num = parseFloat(obj.val());
                            if(!menu_num){
                            	menu_num = 0;
                            }

                            if(parseInt(stock) == 0){
                                alert('该菜品已售罄')
                                return false;
                            }
                            
                            if(stock > menu_num){
                                menu_num++;
                                // obj.val(menu_num);
                                $('.menu-item[data-id='+menu_id+'] .num').val(menu_num);//修改所有该内容数据
                                all = getPrice(0);
                                $.cookie('all',all);
                                $('#allprice').html(all)
                            }else{
                                alert('该菜品选购数量已达上限')
                            }
                        });
                        /*
                        * 份数减少
                            */
                        $(document).on('click','.J_jian',function(){
                            var menu_id = $(this).parents('.menu-item').data('id');
                            var obj = $(this).next().children();
                            var menu_num = parseFloat(obj.val());
                            if(!menu_num){
                            	menu_num = 0;
                            }
                            var stock = parseFloat($(this).next().next().next().val());
                            if(!stock){
                            	stock = 0;
                            }
                            if(menu_num - 1 >= 0){
                                menu_num--;
                                // obj.val(menu_num);
                                $('.menu-item[data-id='+menu_id+'] .num').val(menu_num);//修改所有该内容数据
                                if(menu_num == 0){
                                	$(this).parents('.menu-item').remove();
                                	if($('.menu-cart .menu-item').length == 0){
                                		CartClear();
                                	}
                                }
                                all = getPrice(2);
                                $.cookie('all',all);
                                $('#allprice').html(all);
                            }
                        });
                  })
            </script>  
    </div>

       <?php }else{echo "<script>alert('默认门店状态下只支持预览,无法完成购买')</script>";}?>

         <footer style="background:#fff;z-index: 101;display: block;" id="footer">
        <a class="footer-cart" style="width:25%;" href="javascript:void(0);" onclick="show(event,'cart');">
            <img src="img/icon/购物车-白.png" style="width:50px; height:50px; margin-top:-10px;">
        </a>
<span style="width:100px;height:50px;line-height:50px;color:#81181d;font-size:20px;padding-left:20px;"><b>总计&nbsp;:&nbsp;&nbsp;$</b><span id="allprice">0</span></span>
        <a style="float:right; font-size:12px;width:89px; height:49px; background:#81181d; color:#fff; " onclick="paylist(1)">
        <img src="img/icon/结算-白.png">
        结算</a>
    </footer>

    <div id="fade" class="black_overlay"></div>
    <span></span>
    
    <script type="text/javascript"> 
            $('.details-show').on('click', function(){
                
                layer.open({
              type: 1,
              title: false,
              closeBtn: 1,
              scrollbar: false,
              shadeClose: true,
              skin: 'yourclass',
              content: '<div class="menu-pop" id="pop" ><div class="menu-pop-top"></div><div class="menu-pop-img"><img src="img/images/宅食送页面设计_03.jpg" width="100%" height="100%"></div><div class="menu-pop-content"><p class="p1">咖喱套餐<font style="font-size:9px;">(主菜＋配菜＋米饭)</font></p><p class="p2">汤德&nbsp;&nbsp;川味</p><p class="p2">月售:&nbsp;&nbsp;1231份</p><div class="price"><span>¥26</span><div class="count"><a class="J_jian"><i class="icon-minus-sign"></i></a><label><input type="text" class="num" value="0" disabled="disabled" style="width:30px;background-color:transparent; color:#81181d; border:none; font-size:22px; margin:0 10px; text-align:center;"/></label><a class="J_jia"><i class="icon-plus-sign"></i></a></div></div></div><div class="details"><div style="margin-top:10px; border-top:1px solid #e5e5e5;"></div><span >菜品介绍</span><p></p></div></div>'
        
    
            });
            });
    
    $('.footer-cart1').on('click', function(){
                
                layer.open({
              type: 1,
              title: false,
              closeBtn: 1,
              offset: 'rb',
            area: '100%',
            scrollbar: false,
              shadeClose: true,
              skin: 'yourclass',
              content: '<div class="menu-cart" id="cart"><div class="menu-cart-top"><span>已选餐品</span><a>清空购物车</a></div><div class="menu-cart-content"><div class="order-block"><span class="span-name">香菇鸡肉套餐</span><div  class="count"><a class="J_jian"><i class="icon-minus-sign"></i></a><label><input type="text" class="num" value="0" disabled="disabled" style="width:30px;background-color:transparent; color:#81181d; border:none; font-size:22px; margin:0 10px; text-align:center;"/></label><a class="J_jia"><i class="icon-plus-sign"></i></a></div><span class="span-price">¥26</span></div><div class="order-block"><span class="span-name">莲藕排骨套餐</span><div  class="count"><a class="J_jian"><i class="icon-minus-sign"></i></a><label><input type="text" class="num" value="0" disabled="disabled" style="width:30px;background-color:transparent; color:#81181d; border:none; font-size:22px; margin:0 10px; text-align:center;"/></label><a class="J_jia"><i class="icon-plus-sign"></i></a></div><span class="span-price">¥28</span></div></div><div class="menu-footer"><a><i class=" icon-shopping-cart" style="font-size:40px; float:left; margin-left:30px;"></i></a><a style="float:right; font-size:18px;width:89px; height:49px; background:#dcdcdc; color:#81181d; line-height:49px;" href="signup.html">结算</a></div></div>'
            });
            });
            
            
    </script>
    
</body>
</html>
