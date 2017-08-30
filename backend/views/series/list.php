<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = '分类列表';
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
    top: 25%;  left: 22%;    
    width: 53%;  height: 49%;    
    padding: 8px;    
    border: 5px solid #E8E9F7;    
    background-color: white;    
    z-index:1002;  
    
}  
</style>

<?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>



<hr>
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>分类列表</h5>
          </div>
<!---->
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
    <button class="btn btn-primary" style="margin-left:15px;" id="html">添加类别</button>
   
     <button class="btn btn-info" id="delall">删除</button>
   
          <button class="btn btn-info" id="ac">全选</button>

    
    <!---->
     <!--start-top-serch-->
    <div id="search">
      <input type="text" placeholder="搜索类别名称" id="word"/>
      <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
    </div>
    <!--close-top-serch-->
    </div>
<!---->

          
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                  <th></th>
                  <th>分类名称</th>
                  <th>分类子名称</th>
                  <th>排序</th>
                  <th>线上展示</th>
				          <th>背景图片</th>
				          <th>背景图片</th>
                  <th>分类图片</th>
                  <th>分类描述</th>
                  <th>修改时间</th>
                  <th>修改人</th>
                  <th></th>
                  
                </tr>
              </thead>
              <tbody>
              <?php foreach ($allinfo as $key => $value) {?>
                
            
                <tr class="gradeX">

                


                  <td><input type="checkbox" class="choall"  value="<?=Html::encode($value["series_id"])?>"></td>
                  <td id="n<?=Html::encode($value["series_id"])?>"><?=Html::encode($value["series_name"])?></td>
                  <td><?=Html::encode($value["series_name2"])?></td>
                  <td id="s<?=Html::encode($value["series_id"])?>"><?=Html::encode($value["series_sort"])?></td>
                  <td>
         <?php   if ($value["series_status"]==1) {?>
                   <a href="javascript:void(0)" id="H<?=Html::encode($value["series_id"])?>" class="shangjia" tt="<?=Html::encode($value["series_id"])?>" value="shangjia"><image width="20px" height="20px" src="<?= yii::$app->request->baseUrl?>/assets/ico/png/34.png">
                </a><?php } ?>

                   <?php if ($value["series_status"]==0) {?>
  <a href="javascript:void(0)" id="H<?=Html::encode($value["series_id"])?>" class="xiajia" tt="<?=Html::encode($value["series_id"])?>" value="xiajia"> <image width="20px" height="20px" src="<?= yii::$app->request->baseUrl?>/assets/ico/png/40.png">
                </a>
                <?php } ?>
				

                  </td>
			
					<td>
					<label style="display:block" for="xy<?=Html::encode($value["series_id"])?>"><img title="点击图片可修改" alt="点击图片可修改"  src="<?= yii::$app->request->baseUrl ?>/add/imges/<?=Html::encode( $value["img1"])?>" width="40" height="45"></label>

					<span style="display:none">
					<form name="uploadFrom" id="fxy<?=Html::encode($value["series_id"])?>" action="<?= yii::$app->urlManager->createUrl(['series/fiximg1'])?>" method="post"  target="tarframe" enctype="multipart/form-data">
					<input name="sid" type="hidden"  value="<?=Html::encode($value["series_id"])?>">
					<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
				   <input type="file" id="xy<?=Html::encode($value["series_id"])?>" name="upfile" class="upload_file" valuet="fxy<?=Html::encode($value["series_id"])?>">
				  </form>
				   <iframe src=""  width="0" height="0" style="display:none;" name="tarframe"></iframe>
				  </span>
				
			
				
					</td>
					<td>	
					<label style="display:block" for="yx<?=Html::encode($value["series_id"])?>"><img title="点击图片可修改"  alt="点击图片可修改" src="<?= yii::$app->request->baseUrl ?>/add/imges/<?=Html::encode( $value["img2"])?>" width="40" height="45">	</label>
							<span style="display:none">
					<form name="uploadFrom" id="fyx<?=Html::encode($value["series_id"])?>" action="<?= yii::$app->urlManager->createUrl(['series/fiximg2'])?>" method="post"  target="tarframe" enctype="multipart/form-data">
					<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
					<input name="sid" type="hidden"  value="<?=Html::encode($value["series_id"])?>">
				   <input type="file" id="yx<?=Html::encode($value["series_id"])?>" name="upfile" class="upload_file" valuet="fyx<?=Html::encode($value["series_id"])?>">
				  </form>
				   <iframe src=""  width="0" height="0" style="display:none;" name="tarframe"></iframe>
				  </span>
					</td>

          <td>  
          <label style="display:block" for="yxx<?=Html::encode($value["series_id"])?>"><img title="点击图片可修改"  alt="点击图片可修改" src="<?= yii::$app->request->baseUrl ?>/add/imges/<?=Html::encode( $value["img3"])?>" width="40" height="45">  </label>
              <span style="display:none">
          <form name="uploadFrom" id="fyxx<?=Html::encode($value["series_id"])?>" action="<?= yii::$app->urlManager->createUrl(['series/fiximg3'])?>" method="post"  target="tarframe" enctype="multipart/form-data">
          <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
          <input name="sid" type="hidden"  value="<?=Html::encode($value["series_id"])?>">
           <input type="file" id="yxx<?=Html::encode($value["series_id"])?>" name="upfile" class="upload_file" valuet="fyxx<?=Html::encode($value["series_id"])?>">
          </form>
           <iframe src=""  width="0" height="0" style="display:none;" name="tarframe"></iframe>
          </span>
          </td>


                  <td><?=Html::encode( mb_substr($value["series_desc"], 1,6,'utf-8'))?></td>
                  <td><?= Html::encode($value["end"])?></td>
                  <td><?= Html::encode($value["username"])?></td>
                  <td class="center"><a value="<?=Html::encode($value["series_id"])?>" class="edti" href="javascript:void(0)"><img src="<?= yii::$app->request->baseUrl?>/img/edit.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="del" value="<?= $value["series_id"]?>" href="javascript:void(0)"><img src="<?= yii::$app->request->baseUrl?>/img/delete.png
                 "></a></td>
                  
                 

                </tr>
                <?php  }?>
                
              </tbody>
            </table>
          </div>
        </div>
        <input type="hidden" id="tt" value="<?php echo  \Yii::$app->request->getCsrfToken() ?>">
 <div id="bg"></div>
<div id="show"> 
  <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>类别详细信息</h5>
            <div id="bigshow"></div>
          </div>   
</div>  
   <table style="display:none" class="table table-bordered data-table"></table>
  
<script src="<?= yii::$app->request->baseUrl?>/add/layer/layer.js"></script>
<script src="<?= yii::$app->request->baseUrl?>/add/js/z_zss.min.js"></script>





 <script>
 $(function(){
 $(".upload_file").change(function(){

	 var name = $(this).attr("valuet")


   $("#"+name).submit();
 });
});

function stopSend(str){
	
  layer.msg("修改成功,请重新加载页面");
}





   $("#ac").toggle(
            function () {
              $(".choall").attr("checked",true);
            },
            function () {
              $(".choall").attr("checked",false);
            }
          );

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

$(document).on("click",".shangjia",function(){
id = $(this).attr("tt")
value = $(this).attr("value");

status=1;
tt = $("#tt").val()
              $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['series/fixnow'])?>",
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
                 url: "<?= yii::$app->urlManager->createUrl(['series/fixnow'])?>",
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
        location.href="<?= yii::$app->urlManager->createUrl(['series/search'])?>&key="+word;
        
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
  buer = $("#errorfix").val()
  //alert(buer)
  if (buer) {
   layer.msg(buer);
  };
</script>      
