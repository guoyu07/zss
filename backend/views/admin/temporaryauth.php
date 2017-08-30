<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;

?>
<?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>
<?= Html::jsFile('./assets/order/laydate/laydate.js')?>
<?= Html::cssFile('./assets/order/lab.css')?>
<?= Html::cssFile('./assets/order/xia.css')?>
<?= Html::jsFile('./assets/order/layer.js')?>
<style>
#bg{ display: none;  position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}  
#show{display: none;  position: absolute;  top: 10%;width: 80%;  height: 75%;    border: 8px solid #E8E9F7;  background-color: white;  z-index:1002;  overflow: auto; }
#show1{display: none;  position: absolute; top: 10%; width: 80%;  height: 90%;    border: 8px solid #E8E9F7;  background-color: white;  z-index:1002;  overflow: auto; margin:0 auto;}
</style>
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>临时授权</h5>
          </div>
<div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
    <div id="searchdiv">
		<!--time start -->
        <div class="pull-left">
			<a class="btn btn-primary" href="javascript:void(0);" id="admin">临时授权</a>
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
            <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                  	<th>用户名</th>
                        <th>Email</th>
                        <th>操作</th>
                </tr>
              </thead>
              <tbody>
                    <?php if($admin){ ?>
                            <?php foreach($admin as $key => $val){ ?>
                                    <tr id="user-table-tr-14">
                                            <td>
                                                    <strong>
                                                            <a href="javascript:;"><?= Html::encode($val['username']) ?></a>
                                                    </strong>
                                            </td>
                                            <td>
                                                    <?php if($val['email']){
                                                            echo Html::encode($val['email']);
                                                    }else{
                                                            echo "--";	
                                                    }?><br>
                                            </td>
                                            <td>
                                                  
                                                            <img class="btn btn-default btn-sm TempAllot" data-toggle="modal" data-target="#TempAllot" type="<?= Html::encode($val['id'])?>" alt="查看当前权限" style="cursor:pointer;" src="./assets/order/search.png" title="查看" width=20 height=20 />
                                                            <a href="javascript:;"  class="btn btn-default btn-sm TempDelete" type="<?= Html::encode($val['id'])?>">收回权限</a>
                                                   
                                            </td>
                                    </tr>
                            <?php } ?>
                    <?php }else{ ?>
                            <tr>
                                    <td colspan="20">
                                            <div class="empty">暂无授权用户记录</div>
                                    </td>
                            </tr>
                    <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

<!---遮罩层 start -->
<div id="bg"></div>
<div id="show1">
     <div class="widget-box">
             <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>临时授权</h5><input style="float:right; padding:2px 10px;" id="close" type="button" value="Close"  class="btn btn-inverse btn-mini"/>
          </div> 
                         <div class="widget-content">
                         <?php if($auth){ ?>
                                 <?php 
                                         $form = ActiveForm::begin([
                                                 'options' => ['class' => 'form-horizontal'],
                                                 'action'=>Url::to(['admin/temporarycreate']),
                                                 'method'=>'post',
                                                 'fieldConfig' => [
                                                         'template' => '<div class="form-group"><center><label class="col-md-2 control-label" for="type-name-field">{label}</label></center><div class="col-md-8 controls">{input}{error}</div></div>'
                                                 ], 
                                         ]);
                                 ?>
                                 <table class="table table-bordered data-table">
                                         <tbody>
                                                 <?= Html::input('hidden', 'admin_id', $admin_info['id']) ?>
                                                 <tr>
                                                         <th width="15%">当前管理员名称</th>
                                                         <td width="85%"><?= Html::encode($admin_info['username']) ?></td>
                                                 </tr>

                                                 <tr style="valign:middle;">
                                                         <th>可分配的权限</th>
                                                         <td>
                                                             <table>
                                                                 <?php foreach($auth as $key => $val) { ?>
                                                                                 <td style="width:170px;height:25px;display:block;clear:both;"><?= Html::checkbox('node_id[]', null,['class' => 'che check'.$val['node_id'],'value' => $val['node_id'],'style'=>'clear:both;']) ?>&nbsp;&nbsp;&nbsp;<?= Html::encode($val['node_title']) ?></td>
                                                                         <?php if(isset($val['node'])) { ?>
                                                                                 <?php foreach($val['node'] as $k => $v){?>
                                                                                 <td style="display:block;float:right;margin-right:30px;width:140px;height:25px;"><span style="float:left"><?= Html::checkbox('node_id[]', null,['class' => 'che'.$val['node_id'].' check','value' => $v['node_id'], 'p_id' =>$val['node_id'] ]) ?></span>&nbsp;&nbsp;&nbsp;<span style="float:right"><?= Html::encode($v['node_title']) ?></span></td>
                                                                                 <?php }?>
                                                                         <?php } ?>
                                                                 <?php }?>
                                                                                                 </table>
                                                         </td>
                                                 </tr>

                                                 <tr>
                                                         <th>临时授权名单</th>
                                                         <td>
                                                                 <?= Html::dropDownList('admin', null,ArrayHelper::map($admin_data,'id', 'username'), ['class' => 'form-control admin' ,'style' => 'float:left;']);?>
                                                         </td>
                                                 </tr>

                                                 <tr>
                                                         <th>结束时间</th>
                                                         <td>
                                                                 <?= Html::input('text', 'node_temp_expire',null,['class' => 'date','style' => 'height:35px;float:left;','id' => 'endDateTime','placeholder' => '结束时间','id' =>'endtime' ]) ?>
                                                         </td>
                                                 </tr>
                                         </tbody>
                                 </table>
                         </div>
                         <div class="modal-footer" style="float:left">	
                                 <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
                         </div>
                         <?php ActiveForm::end(); ?>
                         <?php }else{ ?>
                                 <table class="table table-striped table-condenseda table-bordered">
                                         <tbody>
                                                 <tr>
                                                         <td colspan="20">
                                                                 <div class="empty">当前用户没有任何权限无法实现临时授权</div>
                                                         </td>
                                                 </tr>
                                         </tbody>
                                 </table>
                         <?php }?>
             
     
       </div>  
</div>
<div id="show"></div>
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
                                                    loading(1);
                                            },
                                            complete: function(){
                                                    loading(0);
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
                   url: "<?= Yii::$app->urlManager->createUrl([''])?>",
                   data: {id:cid,_csrf:_csrf},
                    beforeSend: function(){
                                 $("#loading").show();
                        },
                        complete: function(){ 
                                 $("#loading").hide();
                        },
                   success: function(msg){          
                                $("#show").html(msg.data)
                                $("#bg").css("display","block")
                                $("#show").css("display","block")
                   }
                })
            })       
      
         
            
            //关闭遮罩层
            $(document).on("click","#btnclose",function(){ 
                 $("#bg").css("display","none")
                 $("#show").css("display","none")
            })
             $(document).on("click","#close",function(){ 
                 $("#bg").css("display","none")
                 $("#show1").css("display","none")
            })
            
         //修改启用状态
        $(document).on("click",".active",function(){
            var status =  $(this).text()
             if($.trim(status) == '启用'){
                $(this).html("<font color='red'>禁用</font>")
                status = 0
             }else{
                $(this).html("<font color='green'>启用</font>")
                status =10
             }
            $.get("<?php echo Yii::$app->urlManager->createUrl(['admin/adminstatus'])?>",{id : $(this).attr("value"),status : status},function(data){
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
                                            loading(1);
                                    },
                                    complete: function(){
                                            loading(0);
                                    },
                               success: function(msg){
                                            $(".widget-content").html(msg);
                               }
                     });	
     });


        //日历
        $(".date").click(function(){
		laydate({
			elem: '#' + $(this).attr('id')
		})
	})

        //全选
	$(document).on("click",".che",function(){
		var val = $(this).val()
		if($(this).prop("checked")==true){
			$(".che"+val).prop("checked",true);
		}else{
			$(".che"+val).prop("checked",false);
		}
	});
	//选择父节点
	$(document).on("click",".check",function(){
		var val = $(this).attr('p_id')
		if($(this).prop("checked")==true){
			$(".check"+val).prop("checked",true);
		}
	});
        
	//详情
	$(".TempAllot").click(function(){
		var id = $(this).attr('type');
                var _csrf = "<?php echo Yii::$app->request->getCsrfToken()?>";
		$.ajax({
			type: "POST",
			url: "<?php echo Url::to(['admin/tempallot']);?>",
                        data: {id : id,_csrf : _csrf},
			dataType: 'json',
                        beforeSend: function(){
                             //    $("#loading").show();
                        },
                        complete: function(){ 
                             //    $("#loading").hide();
                        },
			success: function(msg){
                              
				if (msg.code == 200)
				{
                                    $("#show").html(msg.data); 
                                    $("#bg").css("display","block")
                                    $("#show").css("display","block")                                                               
				}else if(msg.code == 403)
				{
					$("#TempAllot").html('<div class="modal-dialog " style="width:170px;"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title"><font color="red">'+msg.msg+'</font></h4></div></div></div>');
				}
			}
		});
	})    
        
        //临时授权
        $(document).on("click","#admin",function(){    
            $("#bg").css("display","block")
            $("#show1").css("display","block")
        })   
        
	//收回权限
	$(".TempDelete").click(function(){
		if(confirm("您确定要收回权限吗？")){
			var id = $(this).attr('type');
                        var _csrf = "<?php echo Yii::$app->request->getCsrfToken()?>";
			$.ajax({
				type: "POST",
				url: "<?php echo Url::to(['admin/tempdelete']);?>",
				data: {id : id,_csrf : _csrf},
				dataType: 'json',
				success: function(msg){
					if (msg.code == 200) {
						history.go(0)
					}else if(msg.code == 400)
					{
						alert('删除失败')
					}else if(msg.code == 403) 
					{
						alert('暂无权限')
					}
				}
			});
		}
	})
	
	 //添加提示
		buer = $("#errorfix").val()
		  //alert(buer)
		if (buer) {
		   layer.msg(buer)
		};
		
  });

</script>