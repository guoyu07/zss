
<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '服务员订单列表';
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
<div id="smallt" value="0"><h5 id="small"><a href="">我的门店</a></h5></div>
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

          <form method="post" action="<?= yii::$app->urlManager->createUrl(['dangkou/addserise']) ?>" id="myform">
	

            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                  
                  <th>档口</th>
                   <th>档口类别选择</th>
                  <th>选择</th>
                    
                  
                  
                </tr>
              </thead>
              <tbody>
              <?php if (!empty($allinfo["allinfo"])) { ?>
                
           
              <?php foreach ($allinfo["allinfo"] as $key => $value) {?>

                       
            			
                <tr class="gradeX">
                        
                  <td>
                    <h5><?= $value["username"]  ?></h5>
                  </td>

          
                  <td>
                   
                  
                    <?php foreach ($seinfo as $k => $va) { ?>

                    <?php if (empty($allinfo["series"][$key]["d_serice"])) { ?>

                      <?php $arr = array(); ?>

                   <?php  } ?>

                   <?php if (!empty($allinfo["series"][$key]["d_serice"])) { ?>

                       <?php $arr = explode(",",$allinfo["series"][$key]["d_serice"]); ?>

                   <?php  } ?>

                    
                      <?php if (in_array($va["series_id"],$arr)) { ?>
                       
                     
                    <input type="checkbox" class="se"  checked="checked" name="serice<?= $key?>[]" value="<?= Html::encode($va["series_id"])?>"><?= Html::encode($va["series_name"])?>

                     <?php  } ?>  
                      <?php if (!in_array($va["series_id"],$arr)) { ?>
                       
                     
                    <input type="checkbox" class="se" name="serice<?= $key?>[]" value="<?= Html::encode($va["series_id"])?>"><?= Html::encode($va["series_name"])?>

                     <?php  } ?>  


                    <?php } ?>


                  </td>

       
        <td>
			<?php if (in_array($value["id"],$allinfo["alllist"] )) { ?>

			<input type="checkbox" checked="checked" name="waiter<?= $key?>[]" value="<?= Html::encode($value["id"])?>"><?= Html::encode($value["username"])?>


			<?php  }  ?>

			<?php if (!in_array($value["id"],$allinfo["alllist"] )) { ?>

			<input type="checkbox"  name="waiter<?= $key?>[]" value="<?= Html::encode($value["id"])?>"><?= Html::encode($value["username"])?>


			<?php  }  ?>



        </td>                
                </tr>
         
                <?php  }?>
                <tr>
                	
                	<td><input name="shopid" type="hidden" value="<?= $shopid ?>" /><input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">门店档口操作</td>
                  <td></td>
                	<td><input type="button" id="submitt" value="添加"></td>
                </tr>

               <?php }?>
                <?php if (empty($allinfo["allinfo"])) { ?>
                  <font color="red">暂时没有门店档口供选择</font>
                <?php } ?>

				

              </tbody>
            </table>
				
            </form>
          </div>
        </div>
        <input type="hidden" id="tt" value="<?php echo  \Yii::$app->request->getCsrfToken() ?>">


        <script>
        $(function(){
          $("#submitt").click(function(){
            number = "";
            $("input:checkbox:checked").each(function(){

              number = number+ ","+$(this).val()

            });

            newnumber = number.substr(1) 

            $.ajax({
                 type: "GET",
                 url: "<?= yii::$app->urlManager->createUrl(['dangkou/showserise'])?>",
                 async:false,  
                 data: {id:newnumber},
                 success: function(msg){
                   if (msg==1){

                       $("#myform").submit();

                   }else{

                     layer.msg("一个类别只能对应一个档口");
                   } 

                 }
               })


            return false;       

          })

        })





        </script>


  