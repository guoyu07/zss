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

</style>
 

<script type="text/javascript" src="<?= yii::$app->request->baseUrl?>/ueditor/ueditor.config.js"></script>

    <script type="text/javascript" src="<?= yii::$app->request->baseUrl?>/ueditor/ueditor.all.js"></script>

      <script type="text/javascript" src="<?= yii::$app->request->baseUrl?>/ueditor/lang/zh-cn/zh-cn.js"></script>
<hr>
  <input type="hidden" id="shopid" value="<?= $shopid?>">

<?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>
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

    <button class="btn btn-info" id="addall">批量添加</button>
       <button class="btn btn-info" id="ac">全选</button>
    <!---->
     <!--start-top-serch-->
    <div id="search">
      <input type="text" placeholder="搜索....." id="word"/>
      <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
    </div>
    <!--close-top-serch-->
    </div>

          
       
       
          <div id="big">
          <div>
            

          </div>
            <hr >
          <div class="widget-content nopadding">
    `   <div>
    	<select name="" id="choois" style="overflow:scroll; font-size:15px;font-family:楷体">
      <option value="">--请选择--</option>  

    <?php foreach ($allinfo["series"] as $ke => $name) {?>

    	 <option value="<?= Html::encode($name["series_id"])?>"><?= Html::encode($name["series_name"])?></option>	

	<?php  } ?>
    	</select>

    	</div>
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                   <th> </th>
                  <th>菜品名称 </th>
                  <th>类别</th>
                  <th>操作</th>
                 	
                </tr>
              </thead>
               <tbody id="tbody">

              <?php if (!empty($allinfo["list"])) {?>
            
             

			<?php foreach ($allinfo["list"] as $key => $value) {?>
			
			
			<tr>
                <td><input class="choall" type="checkbox" value="<?= Html::encode($value["menu_id"])?>"></td>
          		<td><?= Html::encode($value['menu_name'])?></td>
          		<td><?= Html::encode($value['series_name'])?></td>
          		<td>
          			<a value="<?= Html::encode($value["menu_id"])?>" class="addinfo" href="<?= yii::$app->urlManager->createUrl(['menu/shop-menu-add-info'])?>&id=<?= Html::encode($value["menu_id"])?>&_csrf=<?= \Yii::$app->request->getCsrfToken() ?>&shopid=<?= $shopid?>"><image src="<?= yii::$app->request->baseUrl?>/add/addt.jpg"></a>


          		</td>
          				
             </tr> 
             <?php } ?>  
             <?php  }?>
              <?php if (empty($allinfo["list"])) {?> 
                <image src="<?= yii::$app->request->baseUrl?>/add/no.jpg
                 ">没有可添加的菜品了~~
              <?php }?>
              </tbody>
            </table>


   <input type="hidden" id="tt" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
    <table style="display:none" class="table table-bordered data-table"></table>
     
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

  $("#addall").click(function(){
    var allid = $(".choall::checked");
        tt = $("#tt").val()
        shopid = $("#shopid").val()

        allvalue ="";
        allid.each(function(){ 
            allvalue=allvalue+","+$(this).val();  
        })
        id = allvalue.substr(1);

        if (id==""){

           layer.msg('请先选择添加菜品')
           return false;
        };
      location.href="<?= yii::$app->urlManager->createUrl(['menu/shop-menu-add-info'])?>&id="+id+"&_csrf="+tt+"&shopid="+shopid

  })

    $(document).on("click",".findinfo",function(){
       $("#big").animate({
           opacity: "hide"
       }, "slow");
        $("#smallt").show();
    })



  })


</script>



        <script>



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
        location.href="<?= yii::$app->urlManager->createUrl(['menu/shop-list'])?>&_csrf="+tt+"&search="+word;
        
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

</script> 

<script>
  $(function(){
  //类别选择  
$("#choois").change(function(){

  tt = $("#tt").val()

  shopid = $("#shopid").val();

  var seriesid = $(this).val();

              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/menusearch'])?>",
                 data: {id:seriesid,_csrf:tt,shopid:shopid},
                 dataType:'JSON',
                 success: function(msg){
                 
                  if (msg==1) {
                    alert("没有相关信息");
                  }else{
                    option="";
                    for (var i = msg.length - 1; i >= 0; i--) {
                    option += "<tr class='gradeX'>";
                    option += "<td><input class='choall' type='checkbox' value="+msg[i]['menu_id']+"></td>"
                    option +="<td>"+msg[i]['menu_name']+"</td>";
                    option +="<td>"+msg[i]['series_name']+"</td>";
                     option +="<td>";
                    option +="<a href='index.php?r=menu/shop-menu-add-info&&id="+msg[i]['menu_id']+"&&_csrf="+tt+"'>"

                     option +="<image src='<?= yii::$app->request->baseUrl?>/add/addt.jpg'>"
                     option +="</a>";
                     option += "</td>";
                   
                  option +="</tr>";

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
            $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/del'])?>",
                 data: {id:id,_csrf:_csrf},
                 success: function(msg){

                   if (msg) {
                     
                      $("#A"+id).parent().remove();

                   }else{

                      alert("网络故障,操作失败！")

                       location.reload()

                   }
                 }
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
                 type: "GET",
                 url: "<?= yii::$app->urlManager->createUrl(['menu/delshopmenu'])?>",
                 data: {id:id,_csrf:tt},
                 success: function(msg){

                   if (msg) {

                    location.href="index.php?r=menu/delshopmenu&&post=11&&_csrf="+tt;  

                   }else{

                      alert("网络故障,操作失败！")

                       location.reload()

                   }
                 }
              });

    })

    $(document).on("click",".edti",function(){
     var id = $(this).attr("value")
     sort = $("#A"+id).text()
     name = $("#B"+id).text()
     pricet = $("#C"+id).text()
     content = $("#D"+id).text()
      tt = $("#tt").val()

  //页面层
  layer.open({
    type: 1,
    skin: 'layui-layer-rim', //加上边框
    area: ['520px', '340px'], //宽高
    content: "<center><form method=\"post\" action=\"index.php?r=menu/fixinfo\"><div align=\"center\" style=\"padding-top:30px\"><span></span>名&nbsp;&nbsp;&nbsp;&nbsp;称<input name=\"name\" value="+name+" id=\"name\"  type=\"text\" value=\"\" style=\"height:30px\"><input type=\"hidden\" name=\"id\" value="+id+"><input type=\"hidden\" name=\"_csrf\" value="+tt+"><br />排&nbsp;&nbsp;&nbsp;&nbsp;序<input name=\"sort\" type=\"text\" id=\"sort\" value="+sort+" style=\"height:30px\" ><br />价&nbsp;&nbsp;&nbsp;&nbsp;格<input type=\"text\" name=\"price\" value="+pricet+" style=\"height:30\"><br />描&nbsp;&nbsp;&nbsp;&nbsp;述<textarea name=\"content\">"+content+"</textarea><br />&nbsp;&nbsp;&nbsp;<input  id=\"testButton\" type=\"submit\" value=\"修&nbsp;改\">&nbsp;&nbsp;&nbsp;<input  id=\"reste\" type=\"reset\" value=\"取&nbsp;消\"></form></div></center>",
  });
});   



$(document).on("click","#html",function(){

  location.href="<?= yii::$app->urlManager->createUrl(['menu/shop-menu-add'])?>"

  
});   



  })



</script> 
<script>
  buer = $("#errorfix").val()
  //alert(buer)
  if (buer) {
   layer.msg(buer);
  };
</script>    

