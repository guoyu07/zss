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
            <h5>店面</h5>
          </div>
<!---->
<div id="smallt" value="0"><h5 id="small"><a href="<?= Yii::$app->urlManager->createUrl(['dangkou/index']); ?>"><button class="btn btn-primary" id="ac">未做订单</button></a><a href="<?= Yii::$app->urlManager->createUrl(['dangkou/overmenu']); ?>"><button class="btn btn-info" id="ac">已做订单</button></a></h5></div>
    <div id="searchdiv">
    <!--time start -->
     <!--   <div id="time">
      <button class="btn btn-inverse">时间范围</button>
      <input type="text" id="start_time"  onclick="laydate()"/>
      <input type="text" id="end_time"  onclick="laydate()"/>
    </div>-->
    <!--time end -->
    <!---->
   

    
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
                  <th>订单号</th>
                  <th>菜品</th>
                  <th>操作</th>
                  
                  
                </tr>
              </thead>
              <tbody>
              <?php if (!empty($allinfo)) { ?>
                
           
              <?php foreach ($allinfo as $key => $value) {?>
                
            
                <tr class="gradeX">
                        <td></td>
                  <td>
                    <h5><?= $value["order_sn"]  ?></h5>
                  </td>

        <td>                    <?= Html::encode($value["menu_name"])?>
      </td>
    <td><a href="javascript:void(0)" class="makeit" value="<?= Html::encode($value["info_id"])?>"><button class="btn btn-info">开始制作</button></a></td>                
                </tr>
                <?php  }?>

               <?php }?>
                <?php if (empty($allinfo)) { ?>
                  <font color="red">暂时没有新订单</font>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <input type="hidden" id="tt" value="<?php echo  \Yii::$app->request->getCsrfToken() ?>">


        <script>
        $(function(){

        $(document).on("click",".makeit",function(){

          id = $(this).attr("value");

          $(this).parent().parent().remove();
          $.ajax({
       type: "GET",
       url: "<?= Yii::$app->urlManager->createUrl(['dangkou/fixstatus']); ?>",
       data: "id="+id,
       success: function(msg){

          if (msg>0){

             layer.msg("制作中");
          }else{

    location.reload();
          };

       }
    });

        })


        })
        </script>

  