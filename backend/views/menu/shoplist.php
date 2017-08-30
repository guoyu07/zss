<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '菜单列表';
?>
<style>

.box{padding:20px; background-color:#fff; margin:50px 100px; border-radius:5px;}
.box a{padding-right:15px;}
#about_hide{display:none}
.layer_text{background-color:#fff; padding:20px;}
.layer_text p{margin-bottom: 10px; text-indent: 2em; line-height: 23px;}
.button{display:inline-block; *display:inline; *zoom:1; line-height:30px; padding:0 20px; background-color:#56B4DC; color:#fff; font-size:14px; border-radius:3px; cursor:pointer; font-weight:normal;}
.photos-demo img{width:200px;}
#testButton { color:rgb(0, 0, 0);cursor:pointer;font-size:13px;padding-top:6px;padding-bottom:6px;padding-left:15px;padding-right:15px;border-width:2px;border-color:rgb(170, 170, 170);border-style:double;border-radius:5px;background-color:rgb(242, 242, 242);}#testButton:hover{color:#000000;background-color:#aaaaaa;border-color:#aaaaaa;}
#reste { color:rgb(0, 0, 0);cursor:pointer;font-size:13px;padding-top:6px;padding-bottom:6px;padding-left:15px;padding-right:15px;border-width:2px;border-color:rgb(170, 170, 170);border-style:double;border-radius:5px;background-color:rgb(242, 242, 242);}#testButton:hover{color:#000000;background-color:#aaaaaa;border-color:#aaaaaa;}

#fixreste { color:rgb(0, 0, 0);cursor:pointer;font-size:13px;padding-top:6px;padding-bottom:6px;padding-left:15px;padding-right:15px;border-width:2px;border-color:rgb(170, 170, 170);border-style:double;border-radius:5px;background-color:rgb(242, 242, 242);}#fixButton:hover{color:#000000;background-color:#aaaaaa;border-color:#aaaaaa;}

label{display:none}
#searchdiv{
    display:none;
    height:40px;
  padding:10px;
    //background-color: #efefef;
    border-bottom:2px solid #efefef;
}
#small{
    cursor:pointer;
    height:20px;
    background-color:#efefef;
    text-align:center;
}
.box{padding:20px; background-color:#fff; margin:50px 100px; border-radius:5px;}
.box a{padding-right:15px;}
#about_hide{display:none}
.layer_text{background-color:#fff; padding:20px;}
.layer_text p{margin-bottom: 10px; text-indent: 2em; line-height: 23px;}
.button{display:inline-block; *display:inline; *zoom:1; line-height:30px; padding:0 20px; background-color:#56B4DC; color:#fff; font-size:14px; border-radius:3px; cursor:pointer; font-weight:normal;}
.photos-demo img{width:200px;}
#testButton { color:rgb(0, 0, 0);cursor:pointer;font-size:13px;padding-top:6px;padding-bottom:6px;padding-left:15px;padding-right:15px;border-width:2px;border-color:rgb(170, 170, 170);border-style:double;border-radius:5px;background-color:rgb(242, 242, 242);}#testButton:hover{color:#000000;background-color:#aaaaaa;border-color:#aaaaaa;}
#search{ float:right; margin-right:15px;}
#search input{ float:left; width:220px; height:30px;}
#search button{ float:left; width:45px; height:30px;}
#time button{ float:left; margin:0 5px;}
#time input{ float:left; width:110px; height:30px;font-size:16px;}
.btn-group{margin-right:15px;}

#bg{   
    display: none;    
    position: absolute;    
    top: 0%;  left: 0%;    
    width: 100%;  height: 100%;    
    background-color: black;    
    z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70); /*设置透明度*/  
}  
#show{  
    display: none;    
    position: absolute;    
    top: 5%;  left: 22%;    
    width: 100%;  height:50%;    
    padding: 8px;    
    border: 5px solid #E8E9F7;    
    background-color: white;    
    z-index:1002;  overflow::scroll; 
    
}  
</style>
 <?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

   <input type="hidden" id="tt" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">

<div id="msg">
<hr>
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>菜单列表</h5>
          </div>
<div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
    <div id="searchdiv">
    <!--time start -->
     <!--   <div id="time">
      <button class="btn btn-inverse">时间范围</button>
      <input type="text" id="start_time"  onclick="laydate()"/>
      <input type="text" id="end_time"  onclick="laydate()"/>
    </div>-->
    <!--time end -->
    <!---->
    <button class="btn btn-primary" style="margin-left:15px;" id="html">添加</button>
   
     <button class="btn btn-info" id="delall">删除</button>
     <button class="btn btn-info" id="zkou">折扣</button>
        <button class="btn btn-info" id="ac">全选</button>
   
    
  <input type="hidden" id="shopid" value="<?= $shop_id?>">
    <!---->
     <!--start-top-serch-->
    <div id="search">
      <input type="text" placeholder="搜索....." id="word"/>
      <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
    </div>
    <br>

    <!--close-top-serch-->

    </div>
 <div id="zkbox"style="display:none">
   
   <button class='btn btn-info' id='serieszkou'>类别折扣</button>
<button class='btn btn-info' id='shopzkou'>全店折扣</button>
<button class='btn btn-info' id='morezkou'>多选折扣</button>
 </div>
     <br>
    
    <div id="disck">
    <span id="disckok" style="display:none">
    <select name="" id="zkvalue" style="overflow:scroll; font-size:15px;font-family:楷体">
      <option value="" selected="selected">----选择折扣---</option>
      <?php foreach ($allinfo["discount"] as $diske => $discount) {?>
      <option value="<?= Html::encode($discount["discount_id"])?>">打折：<?= Html::encode($discount["discount_num"]/10)?></option>
      <?php  }?>
     
    </select> <button class='btn btn-info'>选择折扣</button>
    </span>
   
</div>  

<div id="abc" style="display:none">

 <select name="" id="sevalue" style="overflow:scroll; font-size:15px;font-family:楷体;">
     <option value=""  selected="selected">----选择类别---</option>
      <?php foreach ($allinfo["series"] as $seske => $series) {?>
      <option value="<?= Html::encode($series["series_id"])?>">打折：<?= Html::encode($series["series_name"])?></option>
      <?php  }?>
    </select>
    <button class='btn btn-info'>选择类别</button>
    </div>
      
          <div id="big">
          <div>
            

          </div>
          
          <div class="widget-content nopadding">
      
            <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                <th></th>
                   <th>ID</th>
                  <th>排序</th>
                  <th>菜品名称</th>
                  <th style="display:none">菜品名称(缩略图)</th>
                  <th>菜品分类</th>
                  <th>单位</th>
                  <th>原价格</th>
                  <th>价格</th>
                  <th>库存</th>
                  <th style="display:none">描述</th>
                  <th>上架 </th>
                    <th>售卖时间 </th>
                  <th>添加时间</th>
                  <th>修改时间</th>
                  <th>修改人</th>
                  <th style="width:80px"></th>
                </tr>
              </thead>
              <tbody id="tbody">
              <?php if (!empty($allinfo["list"])|| count($allinfo["list"][0])==0) {?>
                <?php foreach ($allinfo["list"] as $key => $value) {?>
               
            
                <tr>
                  <td><input type="checkbox" class="choall" name="" value="<?= Html::encode($value["id"])?>"></td>
                  <td><?= Html::encode($value["id"])?>
				  <span style="display:none" id="dis<?= Html::encode($value["id"])?>"><?= Html::encode($value["discount_num"])?></span>
                  </td>
                  <td><?= Html::encode($value["menu"][0]["menu_sort"])?></td>
                  <td>
                  
                    
                        <?= Html::encode($value["menu"][0]["menu_name"])?>

                   
                   
                       
                    
                
  

            <input type="hidden" id="A<?= Html::encode($value["id"])?>" value="<?= Html::encode($value["menu"][0]["menu_name"])?>">

                  </td>
                  <td style="display:none" id="B<?= Html::encode($value["id"])?>"><image src="<?= yii::$app->request->baseUrl?>/add/menu/<?= Html::encode($value["menu"][0]["image_wx"])?>"></td>
                  <td id="C<?= Html::encode($value["id"])?>"> <?= Html::encode($value["menu"][0]["series_name"])?></td>
                  <td id="D<?= Html::encode($value["id"])?>"><?= Html::encode($value["menu"][0]["menu_code"])?></td>
                  <td id="E<?= Html::encode($value["id"])?>"><?= Html::encode($value["menu"][0]["menu_price"])?></td>
                  <td id="F<?= Html::encode($value["id"])?>">
                   
                      <?php if ($value["discount_num"]!="") {?>

     <?= Html::encode($value["discount_num"]*$value["menu"][0]["menu_price"]*0.01)?>

                      <?php }else{ ?>

                        <?= Html::encode($value["menu"][0]["menu_price"])?>
                      <?php }

                    ?>

      
                  </td>
                  <td id="st<?= Html::encode($value["id"])?>"><?= Html::encode($value["menu_stock"])?></td>
                  <td style="display:none">
                  
  





                <input type="hidden" id="G<?= Html::encode($value["id"])?>" value="<?= Html::encode($value["menu"][0]['menu_introduce'])?>">
                  </td> 
                  <td class="fixnow" value="<?= Html::encode($value["id"])?>" status="<?= Html::encode($value["is_show"])?>" id="H<?= Html::encode($value["id"])?>"><?php
                  if ($value["is_show"]==1) {?>
                   <a href="javascript:void(0)" class="shangjia" tt="<?= Html::encode($value["id"])?>" value="shangjia"><image width="20px" height="20px" src="<?= yii::$app->request->baseUrl?>/assets/ico/png/34.png">
                </a><?php } ?>
                   <?php if ($value["is_show"]==0) {?>
                  <a href="javascript:void(0)" class="xiajia" tt="<?= Html::encode($value["id"])?>" value="xiajia"> <image width="20px" height="20px" src="<?= yii::$app->request->baseUrl?>/assets/ico/png/40.png">
                </a><?php } ?>

                </td>
                  <td id="I<?= Html::encode($value["id"])?>"><?= Html::encode($value["menu_desc"])?></td>
                  <td><?= Html::encode($value["created_at"])?></td>
                  <td><?= Html::encode($value["updated_at"])?></td>
                  <td><?= Html::encode($value["menu"][0]["username"])?></td>
                 <td class="center"><center><a value="<?=Html::encode($value["id"])?>" class="menuallinfo" href="javascript:void(0)"><img alt="查看" title="查看" width="16px" height="18px" src="<?= yii::$app->request->baseUrl?>/assets/order/search.png"></a><a value="<?= Html::encode($value["id"])?>" class="edti" href="javascript:void(0)"><img title="点击编辑" src="<?= yii::$app->request->baseUrl?>/img/edit.png"></a>

                 <a class="del" value="<?=$value["id"]?>" href="javascript:void(0)"><img title="删除" src="<?= yii::$app->request->baseUrl?>/img/delete.png
                 "></a></center></td>
                </tr>
               <?php } ?>   
                
              </tbody>
            </table>
             <?php } ?>

                <?php if (empty($allinfo["list"])) {?>
                     <image src="<?= yii::$app->request->baseUrl?>/add/no.jpg
                 ">什么也没有~~努力去添加~~~~
                <?php } ?>
   </div>  
   <table style="display:none" class="table table-bordered data-table"></table>

<div id="bg"></div>
<div id="show"> 
  <!--
<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>类别详细信息</h5>
            <div id="bigshow"></div>
          </div>  
  --> 
</div>   

 <script src="<?= yii::$app->request->baseUrl?>/add/layer/layer.js"></script>     
<script>
  $(function(){

   $("#ac").toggle(
            function () {
              $(".choall").attr("checked",true);
            },
            function () {
              $(".choall").attr("checked",false);
            }
          );


$(document).on("click",".shangjia",function(){
id = $(this).attr("tt")
value = $(this).attr("value");

status=1;
tt = $("#tt").val()
              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/fixnow'])?>",
                 data: {_csrf:tt,id:id,status:status},
                 success: function(msg){
                    if (!msg) {
                     layer.msg("修改失败");
                    }else{

                          if (value=="shangjia") {
                         $("#H"+id).attr("value","xiajia")
                         $("#H"+id).attr("class","xiajia")  
                         $("#H"+id).attr("tt",id)    
                        $("#H"+id).html("<image width='20px' height='20px' src='<?= yii::$app->request->baseUrl?>/assets/ico/png/40.png'>")
                      }
                     
                        }

                 }
               })

})

$(document).on("click",".xiajia",function(){
id = $(this).attr("tt")
value = $(this).attr("value");

status=0;
tt = $("#tt").val()
              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/fixnow'])?>",
                 data: {_csrf:tt,id:id,status:status},
                 success: function(msg){
                    if (!msg) {
                     layer.msg("修改失败");
                    }else{

                          if (value=="xiajia") {
                         $("#H"+id).attr("value","shangjia") 
                         $("#H"+id).attr("class","shangjia")
                         $("#H"+id).attr("tt",id)    
                        $("#H"+id).html("<image width='20px' height='20px' src='<?= yii::$app->request->baseUrl?>/assets/ico/png/34.png'>")
                      }
                     
                        }

                 }
               })

})



$(document).on("click",".menuallinfo",function(){
 id=$(this).attr("value")
  tt = $("#tt").val()
    menu_name = $("#A"+id).val()
     img = $("#B"+id).html()

     series_name = $("#C"+id).html()
     menu_code = $("#D"+id).html()
     menu_price = $("#E"+id).html()
     discount_num = $("#F"+id).html()
     menu_introduce = $("#G"+id).val()
     is_show = $("#H"+id).html()
     menu_desc = $("#I"+id).html()
     stock = $("#st"+id).html()
       $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/shopmenuinfoshow'])?>",
                 data: {_csrf:tt,img:img,stock:stock,menu_desc:menu_desc,is_show:is_show,menu_introduce:menu_introduce,menu_name:menu_name,series_name:series_name,menu_code:menu_code,menu_price:menu_price,discount_num:discount_num},
                 success: function(msg){

                  $("#msg").html(msg)
                 }


               })

})


 $(document).on("click",".edti",function(){
  var id = $(this).attr("value")
discountnum = $("#dis"+id).html()
  tt = $("#tt").val()
              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/find-discount-info'])?>",
                 data: {_csrf:tt,discountnum:discountnum},
                 success: function(msg){
                   var zk = msg;
     menu_name = $("#A"+id).val()
     img = $("#B"+id).html()
     series_name = $("#C"+id).html()
     menu_code = $("#D"+id).html()
     menu_price = $("#E"+id).html()
     discount_num = $("#F"+id).html()
     menu_introduce = $("#G"+id).val()
     is_show = $("#H"+id).html()
     menu_desc = $("#I"+id).html()
     stock = $("#st"+id).html()

      
  //页面层
  layer.open({
    type: 1,
    skin: 'layui-layer-rim', //加上边框
    area: ['600px', '440px'], //宽高
    content: "<center  style=\" font-size:18px;font-family:楷体\"><form method=\"post\" action=\"index.php?r=menu/shopmenufixinfo\"><div align=\"center\" style=\"padding-top:30px\"><input type=\"hidden\" value="+tt+" name=\"_csrf\"><input type=\"hidden\" value="+id+" name=\"id\"><table><tr><td>菜品：&nbsp;"+menu_name+"<br /></td></tr><tr><td>图片：&nbsp;"+img+"<br></td></tr><tr><td>类别："+series_name+"<br></td></tr><tr><td>单位：&nbsp;"+menu_code+"<br></td></tr><tr><td>价格：&nbsp;"+menu_price+"<br></td></tr><tr><td>折扣："+discount_num+"<br></td></tr><tr><td>时间：<input type=\"text\" style=\"height:30px\" value="+menu_desc+" name=\"menu_desc\" id=\"menu_desc\"><br></td></tr><tr><td>折扣:"+zk+"</td></tr><tr><td>库存：<input type=\"text\" name=\"menu_stock\" value="+stock+" style=\"height:30px\"></td></tr><tr><td><center><input  id=\"testButton\" type=\"submit\" value=\"修&nbsp;改\">&nbsp;&nbsp;&nbsp;<input  id=\"reste\" class=\"colo\" type=\"reset\" value=\"取&nbsp;消\"></center></td></tr></table></form></div></center>",
  });
  }
});   
}); 








    $(document).on("click",".findinfo",function(){
       $("#big").animate({
           opacity: "hide"
       }, "slow");
        $("#smallt").show();
    })


  })

$(".colo").click(function(){

})










function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
}     
$(document).ready(function(){
    $("#small").toggle(function(){
            $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
          },function(){
            $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
     });
   //弹窗显示详细信息
   $(document).on("click","#see",function(){
    id = $(this).attr("value");
    $.ajax({
       type: "GET",
       url: "<?= Yii::$app->urlManager->createUrl(['order/see-order']); ?>",
       data: "id="+id,
       success: function(msg){
        layer.open({
          type: 0,
          skin: 'layui-layer-rim', //加上边框
          area: ['1100px', '540px'], //宽高
          content: "<a id='dian'>测试</a>",
        });
       }
    });
   });
   //搜索
   $(document).on("click",".tip-bottom",function(){
   
        var word = $("#word").val() 
        var tt = $("tt").val(); 
        location.href="<?= yii::$app->urlManager->createUrl(['menu/listshop'])?>&_csrf="+tt+"&search="+word;
        
   });
   $(document).on("click","#li",function(){
     id = $(this).attr("value");
     $("#but").attr("value",id);
    $("#but").html($(this).text());
   });
   $(document).on("click","#li2",function(){
     $("#but2").attr("value",id);
    $("#but2").html($(this).text());
   });
   $(document).on("click","#li3",function(){
     $("#but3").attr("value",id);
    $("#but3").html($(this).text());
   });
});




  $(function(){
  //类别选择  
$("#sevalue").change(function(){
  return false;
  _csrf = $("#tt").val()
  shopid = $("#shopid").val();
  var seriesid = $(this).val();

              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/seriesch'])?>",
                 data: {id:seriesid,_csrf:_csrf,"shopid":shopid},
                 dataType:'JSON',
                 success: function(msg){
                  if (msg==1) {
                    layer.msg("没有相关信息");
                  }else{
                    option="";
                    for (var i = msg.length - 1; i >= 0; i--) {
                    option += "<tr class='gradeX'>";
                    option +="<td><center><input type='checkbox' class='choall'  value="+msg[i]['menu_id']+"></center></td>"
                    option +="<td id=A"+msg[i]['menu_id']+">"+msg[i]['menu_sort']+"</td>"
                     option +="<td id=B"+msg[i]['menu_id']+"class='center'>"+msg[i]['menu_name']+"</td>"
                    option +="<td><img src='<?= yii::$app->request->baseUrl?>/add/menu/"+msg[i]['image_wx']+"'/></td>"
                   option +="<td  class='center'>"+msg[i]["series_name"]+"</td>"
                  option +="<td>份</td>"
                  option +="<td id=C"+msg[i]['menu_id']+" class='center'>"+msg[i]["menu_price"]+"</td>"
                  option +="<td id=D"+msg[i]['menu_id']+" class='center'>"+msg[i]["menu_introduce"]+"</td>"
                  option +="<td>"+msg[i]["start"]+"</td>"
                  option +="<td>"+msg[i]["end"]+"</td>"
                  option +="<td class='center'><center><a value='"+msg[i]['menu_id']+"' class='edti'  href='javascript:void(0)'><img src='<?= yii::$app->request->baseUrl?>/img/edit.png'></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='del' value="+msg[i]['menu_id']+" href='javascript:void(0)'><img src='<?= yii::$app->request->baseUrl?>/img/delete.png'></a></center></td>"

                  option +="</tr>"

                    };
                      $("#tbody").html(option)
                  }
              
                 }

               })

});



          $(document).on("click",".del",function(){
              var _csrf = $("#tt").val()
              
             var id = $(this).attr("value")
             
              $(this).attr("id","d"+id);
          layer.confirm('您确定要删除吗？', {
    btn: ['删除','取消'] //按钮
  }, function(){      
            $.ajax({
                 type: "GET",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/delshopmenu'])?>",
                 data: {id:id,_csrf:_csrf},
                 success: function(msg){

                   if (msg) {
                         layer.msg('删除成功', {icon: 1});
                      $("#A"+id).parent().parent().remove();

                   }else{

                       layer.msg('删除失败', {icon: 0});

                       location.reload()

                   }
                 }
              })
              }, function(){
    //取消执行
  });

          })


    $("#delall").click(function(){
        var allid = $(".choall::checked");
        tt = $("#tt").val()
      
        allvalue ="";
        allid.each(function(){ 
            allvalue=allvalue+","+$(this).val();  
        })
        id = allvalue.substr(1);
 layer.confirm('您确定要删除吗？', {
    btn: ['删除','取消'] //按钮
  }, function(){ 
        $.ajax({
                 type: "GET",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/delshopmenu'])?>",
                 data: {id:id,_csrf:tt,type:1},
                 success: function(msg){

                   if (msg) {
                    //layer.msg('删除成功', {icon: 1});
                    //location.reload()
                    //location.href="index.php?r=menu/delshopmenu&&post=11&&_csrf="+tt;  
                      ss = id.split(",");
                       if(ss){
                       for(i=0;i<ss.length;i++){
                                    $("#A"+ss[i]).parent().parent().remove();
                             layer.msg('删除成功', {icon: 1});
                        }
             
                      }else{
                           $("#A"+id).parent().parent().remove();
                      }
                   }else{

                       layer.msg('删除失败', {icon: 0});

                       //location.reload()

                   }
                 }
              }); }, function(){
    //取消执行
  });

    })





$(document).on("click","#html",function(){
  id = $("#shopid").val()

  location.href="<?= yii::$app->urlManager->createUrl(['menu/shop-menu-add'])?>&id="+id

  
});   



  })



    



$("#morezkou").click(function(){
   tt = $("#tt").val();
   zkvalue = $("#zkvalue").val();
   shopid = $("#shopid").val();
  var allid = $(".choall::checked");     
        allvalue ="";
        allid.each(function(){ 
            allvalue=allvalue+","+$(this).val();  
        })
        allkey = allvalue.substr(1);
     layer.confirm('您确定为该菜品要打折吗？', {
    btn: ['确定','取消'] //按钮
  }, function(){
    if (zkvalue==""||allid==""){
      layer.msg('未选择折扣菜品 或折扣', {icon: 0});return false
   };


     $.ajax({
                 type: "GET",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/change-discount'])?>",
                 data: {id:3,_csrf:tt,discount:zkvalue,allinfo:allkey,shopid:shopid},
                 success: function(msg){
                   if (msg>0) {
                    
             layer.msg('打折成功', {icon: 1});
                //location.reload()
                   }else{

                      layer.msg('打折失败', {icon: 0});
                   }
                 }
              });
    
  }, function(){
    //取消执行
  });

})


$("#shopzkou").click(function(){
  tt = $("#tt").val();
   zkvalue = $("#zkvalue").val();
   shopid = $("#shopid").val();
  layer.confirm('您确定要全店打折吗？', {
    btn: ['确定','取消'] //按钮
  }, function(){
    if (zkvalue==""){
      layer.msg('未选择折扣', {icon: 0});return false
   };


     $.ajax({
                 type: "GET",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/change-discount'])?>",
                 data: {id:2,_csrf:tt,discount:zkvalue,shopid:shopid},
                 success: function(msg){
                   if (msg>0) {
                   
             layer.msg('打折成功', {icon: 1});

                   }else{

                      layer.msg('打折失败', {icon: 0});
                   }
                 }
              });
    
  }, function(){
    //取消执行
  });

})
$("#serieszkou").hover(function(){
$("#abc").show();

})


  $("#serieszkou").click(function(){
      tt = $("#tt").val();
     seriesid = $("#sevalue").val()
     zkvalue = $("#zkvalue").val();
       shopid = $("#shopid").val();
layer.confirm('您确定该类别下全打折吗？', {
    btn: ['确定','取消'] //按钮
  }, function(){
    if (seriesid==""||zkvalue==""){
      layer.msg('未选择折扣或类别', {icon: 0});return false
   };


     $.ajax({
                 type: "GET",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/change-discount'])?>",
                 data: {id:1,_csrf:tt,discount:zkvalue,type:seriesid,shopid:shopid},
                 success: function(msg){
                   if (msg>0) {


             layer.msg('打折成功', {icon: 1});

                   }else{

                      layer.msg('打折失败', {icon: 0});
                   }
                 }
              });
    
  }, function(){
    //取消执行
  });

  })





    $("#zkou").click(function(){
      
    $("#zkbox").show()
    $("#disckok").show()
  
})

</script>
<script>
  buer = $("#errorfix").val()
  //alert(buer)
  if (buer) {
   layer.msg(buer);
  };
</script>  
