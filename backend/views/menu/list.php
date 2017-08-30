<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '菜单列表';
?>
<script src="./assets/order/js/jquery-1.7.min.js"></script>
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



</style>
<?php
            /*if($flash = Yii::$app->session->getFlash('success')) {
                echo "<script> alert('".$flash."')</script>";//页面跳转
            }

            if($flash = Yii::$app->session->getFlash('error')) {
                echo "<script> alert('".$flash."')</script>";//页面跳转
            }*/
            ?>
<?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>


<hr>
<div id="listall">
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>菜单列表</h5>
          </div>
<div id="small" value="0" ><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
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
    <button class="btn btn-info" id="ac">全选</button>
    
    <!---->
     <!--start-top-serch-->
    <div id="search">
      <input type="text" placeholder="搜索菜名" id="word"/>
      <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
    </div>
    <!--close-top-serch-->
    </div>

          
          <hr >
          <div id="big">
          <div>
            <select id="choois" >
            <option value="0">--类别选择--</option>
            <?php foreach ($allser as $key => $value) {?>   
              <option value="<?=Html::encode($value['series_id'])?>"><?=Html::encode($value["series_name"])?></option>
             <?php }?>
            </select>

          </div>
            <hr >
          <div class="widget-content nopadding">
    `   
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                  <th></th>
                   <th>ID</th>
                  <th>排序</th>
                  <th>菜品名称</th>
                  <th style="display:none">菜品名称(缩略图)</th>
                  <th>菜品分类</th>
                  <th>单位</th>
                  <th>价格</th>
                  
                  
                  <th style="display:none">描述</th>
                  <th>添加时间</th>
                  <th>修改时间</th>
                  <th>修改人</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="tbody">
          <?php foreach ($allinfo as $ke => $val) { ?>        
                <tr class="gradeX">
                  <td><center><input type="checkbox" class="choall" value="<?=Html::encode($val["menu_id"])?>"></center></td>
                 <td><?= $val["menu_id"]?></td>
                  <td id="A<?= $val["menu_id"]?>"><?=Html::encode($val["menu_sort"])?></td>
                  
                  <td id= class="center">
                  
<?php   if (strlen($val["menu_name"])>18) {?>
                       <?= Html::encode(substr($val["menu_name"],0,15))?>...

                      <?php } ?>
              <?php   if (strlen($val["menu_name"])<=18) {?>
                        <?= Html::encode($val["menu_name"])?>

                      <?php } ?>

                  <input type="hidden" id="B<?= $val["menu_id"]?>" value="<?= $val["menu_name"]?>">

                  </td>
                  <td style="display:none" id="E<?= $val["menu_id"]?>"><img src="<?= yii::$app->request->baseUrl?>/add/menu/<?=Html::encode($val["image_wx"])?>"/></td>
                  <td  class="center" id="F<?= $val["menu_id"]?>"><?=Html::encode($val["series_name"])?></td>
                  <td id="G<?= $val["menu_id"]?>"><?=Html::encode($val["menu_code"])?></td>
                  <td id="C<?= $val["menu_id"]?>" class="center"><?=Html::encode($val["menu_price"])?></td>
                  <td style="display:none" id=""><div>

                 

<?php   if (strlen($val["menu_introduce"])>18) {?>
                       <?= Html::encode(substr($val["menu_introduce"],0,15))?>...

                      <?php } ?>
              <?php   if (strlen($val["menu_introduce"])<=18) {?>
                        <?= Html::encode($val["menu_introduce"])?>

                      <?php } ?>




                  </div>
                  
                  <input type="hidden" id="D<?= $val["menu_id"]?>" value="<?= $val["menu_introduce"]?>">
                  </td>
                  <td id="H<?= $val["menu_id"]?>"><?=Html::encode($val["start"])?></td>
                  <td id="I<?= $val["menu_id"]?>"><?=Html::encode($val["end"])?></td>
                  <td id="J<?= $val["menu_id"]?>"><?=Html::encode($val["username"])?></td>
                  <td class="center"><center><a value="<?=Html::encode($val["menu_id"])?>" class="menuallinfo" href="javascript:void(0)"><img alt="查看" title="查看" width="16px" height="18px" src="<?= yii::$app->request->baseUrl?>/assets/order/search.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a value="<?=Html::encode($val["menu_id"])?>" class="edti" href="javascript:void(0)"><img src="<?= yii::$app->request->baseUrl?>/img/edit.png" title="编辑"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="del" value="<?= $val["menu_id"]?>" href="javascript:void(0)"><img title="删除" src="<?= yii::$app->request->baseUrl?>/img/delete.png
                 "></a></center></td>
                </tr>
              <?php }?>
                
                
              </tbody>
            </table>
          </div>
        </div>
        </div>  

        <input type="hidden" id="tt" value="<?php echo  \Yii::$app->request->getCsrfToken() ?>">
 </div> 
              <table style="display:none" class="table table-bordered data-table"></table>
     
<script src="<?= yii::$app->request->baseUrl?>/add/layer/layer.js"></script>


<script>

$("#ac").toggle(
            function () {
              $(".choall").attr("checked",true);
            },
            function () {
              $(".choall").attr("checked",false);
            }
          );
$(document).on("click",".menuallinfo",function(){

     var id = $(this).attr("value")
     sort = $("#A"+id).text()
     name = $("#B"+id).val()
     price = $("#C"+id).text()
     menuintroduce = $("#D"+id).val()
     img = $("#E"+id).html()
     series_name = $("#F"+id).text()
     menu_code = $("#G"+id).text()
     addtime = $("#H"+id).text()
    fixtime = $("#I"+id).text()
    fixman = $("#J"+id).text()
     
     _csrf = $("#tt").val()


  var seriesid = $(this).val();

              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/menuallinfo'])?>",
                 data: {fixman:fixman,fixtime:fixtime,addtime:addtime,menu_code:menu_code,series_name:series_name,price:price,menuintroduce:menuintroduce,img:img,name:name,sort:sort,_csrf:_csrf},
                 success: function(msg){
                  $("#listall").html(msg)
                 }

               })


     
})
  $(document).on("click",".edti",function(){
     var id = $(this).attr("value")
     sort = $("#A"+id).text()
     name = $("#B"+id).val() 
     price = $("#C"+id).text()
     menuintroduce = $("#D"+id).val()
     img = $("#E"+id).html()
     series_name = $("#F"+id).text()
     menu_code = $("#G"+id).text()
     
      _csrf = $("#tt").val()

  var seriesid = $(this).val();

              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/fixmenuinfo'])?>",
                 data: {id:id,menu_code:menu_code,series_name:series_name,price:price,menuintroduce:menuintroduce,img:img,name:name,sort:sort,_csrf:_csrf},
                 success: function(msg){
                 
                  $("#listall").html(msg)
                 }

               })
    

   
});   








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
        location.href="<?= yii::$app->urlManager->createUrl(['menu/search'])?>&key="+word;
        
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



  //类别选择  
$("#choois").change(function(){

  _csrf = $("#tt").val()

  var seriesid = $(this).val();

              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/seriesch'])?>",
                 data: {id:seriesid,_csrf:_csrf},
                 dataType:'JSON',
                 success: function(msg){

                  if (msg==1) {
                   layer.msg("没有相关信息");
                  }else{
                    
                    
                    option="";
                    for (var i = msg.length - 1; i >= 0; i--) {
                      if (msg[i]['menu_name'].length>15){
                     name =  msg[i]['menu_name'].substr(0,15)+"...";
                    }else{
                      name =  msg[i]['menu_name'];
                    }
                    if (msg[i]["menu_introduce"].length>15){
                     menu_introduce =  msg[i]["menu_introduce"].substr(0,15)+"..."
                    }else{
                      menu_introduce =  msg[i]["menu_introduce"];
                    }

                    option += "<tr class='gradeX'>";
                    option +="<td><center><input type='checkbox' class='choall'  value="+msg[i]['menu_id']+"></center></td>"
                    option +=   "<td><h5>"+msg[i]['menu_id']+"</h5></td>"
                    option +="<td id=A"+msg[i]['menu_id']+">"+msg[i]['menu_sort']+"</td>"
                    option +="<td id=B class='center'>"+name+"<input type='hidden' id='B"+msg[i]['menu_id']+"' value="+msg[i]['menu_name']+"></td>"
                    option +="<td style='display:none' id=E"+msg[i]['menu_id']+"><img src='<?= yii::$app->request->baseUrl?>/add/menu/"+msg[i]['image_wx']+"'/></td>"
                    option +="<td id=F"+msg[i]['menu_id']+"  class='center'>"+msg[i]["series_name"]+"</td>"
                    option +="<td id=G"+msg[i]['menu_id']+">"+msg[i]["menu_code"]+"</td>"
                    option +="<td id=C"+msg[i]['menu_id']+" class='center'>"+msg[i]["menu_price"]+"</td>"
                    option +="<td style='display:none' id= class='center'>"+menu_introduce+"<input type='hidden' id=D"+msg[i]['menu_id']+" value="+msg[i]["menu_introduce"]+"></td>"
                    option +="<td>"+msg[i]["start"]+"</td>"
                    option +="<td>"+msg[i]["end"]+"</td>"
                    option +="<td>"+msg[i]["username"]+"</td>"
                    option +="<td class='center'><center><a value='"+msg[i]['menu_id']+"'class='menuallinfo' href='javascript:void(0)'><img width='16px' height='18px' src='<?= yii::$app->request->baseUrl?>/assets/order/search.png'></a>&nbsp;&nbsp;&nbsp;&nbsp;<a value='"+msg[i]['menu_id']+"' class='edti'  href='javascript:void(0)'><img src='<?= yii::$app->request->baseUrl?>/img/edit.png'></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='del' value="+msg[i]['menu_id']+" href='javascript:void(0)'><img src='<?= yii::$app->request->baseUrl?>/img/delete.png'></a></center>"
                    option += "</td>";
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
          layer.confirm('门店下有该菜品您确定要删除吗？', {
    btn: ['删除','取消'] //按钮
  }, function(){      
            $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/del'])?>",
                 data: {id:id,_csrf:_csrf},
                 success: function(msg){

                   if (msg) {
                         layer.msg('删除成功', {icon: 1});
                      $("#A"+id).parent().remove();

                   }else{

                       layer.msg('删除失败', {icon: 0});

                       

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
       

        $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/del'])?>",
                 data: {id:id,_csrf:tt},
                 success: function(msg){

                   if (msg) {

                   ss = id.split(",");
                       if(ss){
                       for(i=0;i<ss.length;i++){
                                    $("#A"+ss[i]).parent().remove();
                             layer.msg('删除成功', {icon: 1});
                        }
             
                      }else{
                           $("#A"+id).parent().remove();
                      }

                   }else{

                      layer.msg("网络故障,操作失败！")

                       location.reload()

                   }
                 }
              });

    })

    



$(document).on("click","#html",function(){

  location.href="<?= yii::$app->urlManager->createUrl(['menu/add'])?>"

}) 
</script> 
<script>
  buer = $("#errorfix").val()
  //alert(buer)
  if (buer) {
   layer.msg(buer);
  };
</script>    
