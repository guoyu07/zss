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
<script src="./assets/order/laydate/laydate.js"></script>
<link rel="stylesheet" href="./assets/order/lab.css" />
<link rel="stylesheet" href="./assets/order/xia.css" />

<style>
#bg{ display: none;  position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 150%;  background-color: black;  z-index:1000;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}  
#show{display: none;  position: absolute;  top: 10%;  width: 70%;  height: 70%;    border: 8px solid #E8E9F7;  background-color: white;  z-index:1002;  overflow: auto; }
#show1{display: none;  position: absolute;  top: 10%;    width: 70%;  height: 70%; margin-left: 50px;    border: 8px solid #E8E9F7;  background-color: white;  z-index:1002;  overflow: auto; margin-left: 60px;}
</style>
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>管理员列表</h5>
          </div>
<div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
    <div id="searchdiv">
		<!--time start -->
        <div class="pull-left">
			<a class="btn btn-primary" href="javascript:void(0);" id="admin">添加管理员</a>
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
            <table class="table table-bordered data-table" style="overflow:scroll; ">
              <thead>
                <tr>
                                        <th>用户名</th>
					<th>Email</th>
                                        <th>职位类型</th>
					<th>注册时间</th>
					<th>最近登录</th>
                                        <th>状态</th>
					<th>操作</th>
                </tr>
              </thead>
              <tbody>
			  <?php if($data){?>
					<?php foreach($data as $key => $val){?>
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
								<?php if(isset($val['type'])){
                          if($val['type'] == 1){
                              echo "管理员";
                          }elseif($val['type'] == 2){
                              echo "店长";
                          }elseif($val['type'] == 3){
                              echo "外卖员";
                          }elseif($val['type'] == 4){
                              echo "档口";
                          }elseif($val['type'] == 5){
                              echo "服务员";
                          }								
        								}else{
        									echo "--";	
        								}?><br>
							</td>
							<td>
								<span class="text-sm">
								<?php if($val['created_at']){
									echo date("Y-m-d H:i:s",Html::encode($val['created_at']));
								}else{
									echo "--";	
								}?></span>
							</td>
							<td>
								<span class="text-sm">
								<?php if($val['login_time']){
									echo date("Y-m-d H:i:s",Html::encode($val['login_time']));
								}else{
									echo "--";	
								}?></span>
								<br>
								<span class="text-muted text-sm">
									<?php if($val['login_ip']){?>
										<a class="text-muted text-sm" href="http://www.baidu.com/s?wd=<?php echo Html::encode($val['login_ip']) ?>" target="_blank"><?php echo Html::encode($val['login_ip']) ?></a>
									<?php }else{
										echo "--";
									}?>
								</span>
							</td>
                                                        <td  class="active"  value='<?= Html::encode($val['id'])?>' type="<?= Html::encode($val['status'])?>">
                                                            <?php if($val['status'] == 10){?>                                                                                                      <img src="./assets/ico/png/34.png" width=20 height=20 /> 
                                                            <?php }else{?>
                                                             <img src="./assets/ico/png/40.png" width=20 height=20/>
                                                            <?php }?>
                                                            
                                                        </td>
							<td>
								<img id="see" value="<?= Html::encode($val['id']) ?>"  class="upd" alt="查看" style="cursor:pointer;" src="./assets/order/search.png" title="查看" width=20 height=20 /> &nbsp;&nbsp; <img  value="<?= Html::encode($val['id']) ?>" class="add" src="/assets/img/add.png" alt="添加权限" title="添加权限" width=20 height=20/>

							
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
<div  id="show1"  >
     
    <div class="widget-box">
                                  <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
            <h5>添加管理员</h5><input style="float:right; padding:2px 10px;" id="close" type="button" value="Close" onclick="hidediv();" class="btn btn-inverse btn-mini"/>
          </div>
          <div class="widget-content">
				<?php 
					$form = ActiveForm::begin([
						'options' => ['class' => 'form-horizontal',
						'id'=>'Users-form'],
						'action'=>Url::to(['admin/admincreate']),
						'method'=>'post',
						'fieldConfig' => [
							'template' => '<div class="form-group"><center><label class="col-md-2 control-label" for="type-name-field" style="display: block; width: 100px;">{label}</label></center><div class="col-md-8 controls" style="margin-left: 140px;">{input}{error}</div></div>'
						], 
					]);
				?>
				 <table >
              <tr>	
                  <td>名称:</td><td><?= $form->field($model, 'username',['inputOptions'=>['placeholder'=>'请输入用户名']])->textInput(['maxlength' => true,'style' =>'height:30px;'])->label('名称') ?></td>
              </tr>	
              <tr>	
                  <td>邮箱:</td><td><?= $form->field($model, 'email',['inputOptions'=>['placeholder'=>'请输入邮箱']])->textInput(['maxlength' => true,'style' =>'height:30px;'])->label('邮箱') ?></td>
              </tr>
              <tr>
				<td>密码:</td><td><?= $form->field($model, 'password_hash',['inputOptions'=>['placeholder'=>'请输入密码']])->passwordInput(['maxlength' => true,'style' =>'height:30px;'])->label('密码') ?></td>
              </tr>
              <tr>
				<td>确认密码:</td><td><?= $form->field($model, 'password_re',['inputOptions'=>['placeholder'=>'请输入确认密码']])->passwordInput(['maxlength' => true,'style' =>'height:30px;'])->label('确认密码') ?></td>
              </tr>
               <tr>
				<td>职位类型:</td><td><?= $form->field($model, 'type')->dropDownList(['1' => '管理员', '2' => '店长', '3' => '外卖员', '4' => '档口', '5' => '服务员']); ?></td>
              </tr>
		<tr>			
                    <td>&nbsp;	&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;<?= Html::submitButton('保存', ['class' => 'btn btn-success','id'=>'user-create-btn']) ?></td><td></td>
						
                 </tr>			
				 </table>
				<?php ActiveForm::end(); ?>
             </div>                         	
  </div>
          

    
</div>
<div id="show">	</div>
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
                                                  //  loading(1);
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
                               //  $("#loading").show();
                        },
                        complete: function(){ 
                              //   $("#loading").hide();
                        },
                   success: function(msg){          
                        if( msg['code'] == '200'){
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
                              //   $("#loading").show();
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
            
            //添加管理员
            $(document).on("click","#admin",function(){    
                $("#bg").css("display","block")
                $("#show1").css("display","block")
 
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
            var status =  $(this).attr("type")
             if(status == 10){
                 status = 0
                $(this).attr('type','0')              
                $(this).html("<img src='\/assets\/ico\/png\/40.png' width=20 height=20 \/>")
               
             }else{
                status =10
                $(this).attr('type','10')
                $(this).html("<img src='\/assets\/ico\/png\/34.png' width=20 height=20 \/>")
                
             }
            $.get("<?php echo Yii::$app->urlManager->createUrl(['admin/adminstatus'])?>",{id : $(this).attr("value"),status : status},function(data){
                 if( data['code'] == '200' ){
                     //修改成功
                    }else if(data['code'] == '400'){
                        alert('修改状态失败')
                    }else if(data['code'] == '403'){
                        alert('没有权限')
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
	 
	 //添加提示
		buer = $("#errorfix").val()
		  //alert(buer)
		if (buer) {
		   layer.msg(buer)
		};

});

  

</script>