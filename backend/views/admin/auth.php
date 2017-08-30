<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '权限管理';
?>
<script src="./assets/order/laydate/laydate.js"></script>
<link rel="stylesheet" href="./assets/order/lab.css" />
<link rel="stylesheet" href="./assets/order/xia.css" />
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>管理员列表</h5>
          </div>
<div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
    <div id="searchdiv">
		<!--time start -->
        <div class="pull-left">
			
		</div>
		<!------>
		 <!--start-top-serch-->
		<div id="search">
			<input type="text" placeholder="搜索..." id="word"/>
			<button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
		</div>
		<!--close-top-serch-->
    </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                  	<th>名称</th>
					<th>名称描述</th>
					<th>状态</th>
					<th>排序</th>
                                        <th>备用信息</th>
					
                </tr>
              </thead>
              <tbody>
			  <?php if($data){?>
					<?php foreach($data as $key => $val){?>
						<tr id="user-table-tr-14">
							<td>
								<strong>
									<a href="javascript:;"><?= Html::encode($val['node_name']) ?></a>
								</strong>								
							</td>
							<td>
								<?php if($val['node_title']){
									echo Html::encode($val['node_title']);
								}else{
									echo "--";	
								}?><br>
							</td>
							 <td  class="active"  value='<?= Html::encode($val['node_id'])?>' type="<?= Html::encode($val['node_status'])?>">
                                                            <?php if($val['node_status'] == 1){?>                                                                                                          <img src="./assets/ico/png/34.png" width=20 height=20 /> 
                                                            <?php }else{?>
                                                                     <img src="./assets/ico/png/40.png" width=20 height=20/>
                                                            <?php }?>
                                                            
                                                        </td>
							<td>
                                                            <?php if($val['node_sort']){
									echo Html::encode($val['node_sort']);
                                                            }else{
									echo "--";	
                                                            }?>
							</td>
                                                        <td>
                                                          	<?php if($val['node_remark']){
									echo Html::encode($val['node_remark']);
								}else{
									echo "--";
								}?>
                                                        </td>
						</tr>
					<?php }}else{?>
						<tr>
							<td colspan="20">
								<div class="empty">暂无管理员记录</div>
							</td>
						</tr>
					<?php }?>
              </tbody>
            </table>
          </div>
        </div>

<!---遮罩层 start -->
<div id="bg"></div>
<div id="show">		
</div>
<img id="loading"  style=" display:none; z-index:999; position:fixed; top:50%; margin-top:-100px; left:50%; margin-left:-150px;"  src="./assets/order/loading.gif">
<script src="./assets/order/layer.js"></script>
<script>
$(document).ready(function(){

    //查询
    $(".select").each(function(){
                    var s=$(this);
                    var z=parseInt(s.css("z-index"));
                    var dt=$(this).children("dt");
                    var dd=$(this).children("dd");
                    var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   //展开效果
                    var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    //关闭效果
                    dt.click(function(){dd.is(":hidden")?_show():_hide();});
                    dd.find("a").click(function(){ 
                            id = $(this).attr("value");
                            dt.attr("value",id);
                            dt.html($(this).html());_hide();
                            //查询 && 取得传值信息
                            pay_type = $("#pay_type").attr("value");
                            pay_status = $("#pay_status").attr("value");
                            delivery_type = $("#delivery_type").attr("value");
                            $.ajax({
                       type: "GET",
                                       url: "<?= Yii::$app->urlManager->createUrl(['order/search-order']) ?>",
                                       data: "pay_type="+pay_type+"&pay_status="+pay_status+"&delivery_type="+delivery_type,
                                       beforeSend: function(){
                                               //     loading(1);
                                            },
                                            complete: function(){
                                                //    loading(0);
                                            },
                                       success: function(msg){
                                                    $(".widget-content").html(msg);
                                       }
                            });
                    });     //选择效果（如需要传值，可自定义参数，在此处返回对应的“value”值 ）
                    $("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
    })

     //查看详情
            $(document).on("click",".upd",function(){
                var cid = $(this).attr("value")
                var _csrf = "<?php echo Yii::$app->request->getCsrfToken()?>"
               // var zhe = "";
                $.ajax({
                   type: "POST",
                   url: "<?= Yii::$app->urlManager->createUrl(['admin/admininfo'])?>",
                   data: {id:cid,_csrf:_csrf},
                    beforeSend: function(){
                             //    $("#loading").show();
                        },
                        complete: function(){ 
                               //  $("#loading").hide();
                        },
                   success: function(msg){   
                        if(msg['code'] == '200'){
                            $("#show").html(msg['data'])
                            //开启遮罩层 
                            $("#bg").css("display","block")
                            $("#show").css("display","block")
                        }else if(msg['code'] == '400'){
                            alert('失败')
                        }else if(msg['code'] == '403'){
                            alert('暂无权限')
                        }
                   }
                })
            })       
        //分配角色
            $(document).on("click",".add",function(){
                var cid = $(this).attr("value")
                var _csrf = "<?php echo Yii::$app->request->getCsrfToken()?>"
               // var zhe = "";
                $.ajax({
                   type: "POST",
                   url: "<?= Yii::$app->urlManager->createUrl(['admin/roleallot'])?>",
                   data: {id:cid,_csrf:_csrf},
                    beforeSend: function(){
                             //    $("#loading").show();
                        },
                        complete: function(){ 
                          //       $("#loading").hide();
                        },
                   success: function(msg){          
                        if(msg['code'] == '200'){
                         $("#show").html(msg['data'])
                         //开启遮罩层 
                         $("#bg").css("display","block")
                         $("#show").css("display","block")
                        }else if(msg['code'] == '400'){
                            alert('失败')
                        }else if(msg['code'] == '403'){
                            alert('暂无权限')
                        }
                   }
                })
            })          
            
            //添加管理员
            $(document).on("click","#admin",function(){    
                $("#bg").css("display","block")
                $("#show").css("display","block")
 
            })   
            
            //关闭遮罩层
            $(document).on("click","#btnclose",function(){ 
                 $("#bg").css("display","none")
                 $("#show").css("display","none")
            })
            
         //修改启用状态
        $(document).on("click",".active",function(){
           var status =  $(this).attr("type")
             if(status == 1){
                 status = 0
                $(this).attr('type','0')              
                $(this).html("<img src='\/assets\/ico\/png\/40.png' width=20 height=20 \/>")
               
             }else{
                status =1
                $(this).attr('type','1')
                $(this).html("<img src='\/assets\/ico\/png\/34.png' width=20 height=20 \/>")
                
             }
            $.get("<?php echo Yii::$app->urlManager->createUrl(['admin/authstatus'])?>",{id : $(this).attr("value"),status : status},function(data){
                    if( data['code'] == '200' ){
                     //修改成功
                    }else{
                        alert('修改状态失败')
                    }
            })
        })


        $("#small").toggle(function(){
                $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
                $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
              },function(){
                $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
                $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
         });

     //模糊查询搜索
     $(document).on("click",".tip-bottom",function(){
             word = $("#word").val();
             start_time = $("#start_time").attr("value");
             end_time = $("#end_time").attr("value");
             $.ajax({
                               type: "POST",
                               url: "<?= Yii::$app->urlManager->createUrl(['order/like-order']); ?>",
                               data: "word="+word+"&start_time="+start_time+"&end_time="+end_time,
                               beforeSend: function(){
                                      //      loading(1);
                                    },
                                    complete: function(){
                                    //        loading(0);
                                    },
                               success: function(msg){
                                            $(".widget-content").html(msg);
                               }
                     });	
     });

});

  

</script>