<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
$this->title = '会员等级管理';
?>
<?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>
<style>
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
.button{display:inline-block; *display:inline; *zoom:1; line-height:30px; padding:0 20px; background-color:#56B4DC; color:#fff; font-size:14px; border-radius:3px; cursor:pointer; font-weight:normal;}
.photos-demo img{width:200px;}
#search{ float:right; margin-right:15px;}
#search input{ float:left; width:220px; height:30px;}
#search .tip-bottom{ float:left; width:45px; height:30px;}
#bt1{ float:left;}
.btn-group{margin-right:15px; float:right;}
#bg{ display: none;  position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}
#show{display: none;  position: absolute;  top: 15%;  left: 10%;  width: 65%;  height: 65%;  padding: 8px;  border: 8px solid #E8E9F7;  background-color: white;  z-index:1002;  overflow: auto;}

</style>

<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>会员等级</h5>
          </div>
	<div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
    <div id="searchdiv">
         <!--start-top-serch-->
         <div id='bt1'>
            <a   href='<?php echo Yii::$app->urlManager->createUrl(['user/adrank']);?>'><button class='btn btn-primary'>添加</button></a>&nbsp;&nbsp; <button class='btn1 btn btn-info'>删除</button>&nbsp;&nbsp;<button class='che btn btn-info'>全选</button></button>&nbsp;&nbsp;<button class='exp btn btn-info'>经验信息设置</button>
         </div>
        <div id="search">

                <input type="text" placeholder="搜索等级名称..." id="word"/>
                <button  class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </div>
        <!--close-top-serch-->
    </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                    <th><span disabled></span></th>
                    <th>ID</th>
                    <th>名称</th>
                    <th>折扣</th>
                    <th>满</th>
                    <th>减</th>
                    <th>上次修改人</th>
                    <th>状态</th>
                    <th>经验值</th>
                    <th>操作</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach($rank as $models){;?>
                    <tr class="gradeX">
                      <td><input type="checkbox"   class='one' value='<?= Html::encode($models['vip_id']) ?>' /></td>
                      <td><?= Html::encode($models['vip_id']);?></td>
                      <td><?= Html::encode($models['vip_name']);?></td>
                      <td><?= Html::encode($models['vip_discount']);?></td>
                      <td class="center"><?= Html::encode($models['vip_price']);?></td>
                      <td><?= Html::encode($models['vip_subtract']);?></td>
                      <td>
                      <?php if(isset($models['username'])){?>
                      <?= Html::encode($models['username']);?>
                      <?php }else{?>
                          *未做修改*
                          <?php }?>
                      </td>
                       <td class="active"  value='<?= Html::encode($models['vip_id'])?>' type="<?= Html::encode($models['vip_status'])?>">
                     <?php if($models['vip_status'] == 1){?>
                     <img src="./assets/ico/png/34.png" width=20 height=20 />
                         <?php }else{?>
                     <img src="./assets/ico/png/40.png" width=20 height=20/>
                         <?php }?>
                     </td>
                     <td><?= Html::encode($models['vip_experience']);?></td>
                      <td><a href="javascript:void(0);" class="upd"  id="<?= Html::encode($models['vip_id']);?>" value="<?= Html::encode($models['vip_id']);?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/order/search.png"  width=20 height=20/></a>&nbsp;&nbsp;<a  href="<?php echo Yii::$app->urlManager->createUrl(['user/updvip'])?>&cid=<?= Html::encode($models['vip_id']);?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/actions/edit.png"/></a>&nbsp;&nbsp;&nbsp;<a  href="javascript:void(0)" class="del" id="d<?= Html::encode($models['vip_id']);?>" value="<?= Html::encode($models['vip_id']);?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/actions/delete.png"/></a></td>
                    </tr>
                  <?php };?>

              </tbody>
            </table>
          </div>
        </div>
<div style="display:none">
    <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体"></table>
</div>
<div id="bg">

    </div>
    <div id="show">

        <input id="btnclose" type="button" value="加载中............."/>
    </div>  <img id="loading"  style=" display:none; z-index:999; position:fixed; top:50%; margin-top:-100px; left:50%; margin-left:-150px;"  src="./assets/order/loading.gif">

<script>

    $(function(){
        //展开展出
        $("#small").toggle(function(){
            $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
          },function(){
            $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        });

        //搜索
        $(document).on("click",".tip-bottom",function(){
            var search = $("#word").val();
            //var newDate = new Date();
            $.get("<?php echo Url::to(['user/findrank']);?>",{search : search},function(data){
                if(data['code'] == '200'){
                    $(".widget-content").html(data['data'])
                }else if(data['code'] == '400'){
                    alert('失败')
                }else if(data['code'] == '403'){
                    alert('暂无权限')
                }
            })
        })

        //删除弹窗
        $(document).on("click",".del",function(){
            var cid = $(this).attr("value")
            //询问框
            layer.confirm('您确定要删除吗？', {
              btn: ['删除','取消'] //按钮
            }, function(){
                $.get("<?php echo Url::to(['user/delrank']);?>",{cid : cid},function(data){
                    if( data['code'] == '200' ){
                       layer.msg('删除成功', {icon: 1});
                       $("#d"+cid).parent().parent().remove();
                    }else if( data['code'] =='400' ){
                        layer.msg('删除失败', {icon: 0});
                    }else if( data['code'] == '403'){
                        alert('暂无权限')
                    }
                })

            }, function(){
                    //取消执行
            });
        });

        //批量删除
        $(document).on("click",".btn1",function(){
            var one = $(".one:checked")
            var mid = [];
            one.each(function(){
                mid.push($(this).val())
             })
             mid = mid.join(',')
             //询问框
            layer.confirm('您确定要删除吗？', {
              btn: ['删除','取消'] //按钮
            }, function(){
                $.get("<?php echo Url::to(['user/delrank']);?>",{cid : mid},function(data){
                    if( data['code'] == '200' ){
                       layer.msg('删除成功', {icon: 1});
                       location.reload()
                    }else if( data['code'] == '400' ){
                       layer.msg('删除失败', {icon: 0});
                    }else if( data['code'] == '403' ){
                        alert('暂无权限')
                    }
                })

            }, function(){
                    //取消执行
            });

         })

           //全选
         $(".che").toggle(
            function () {
              $(".one").attr("checked",true);
            },
            function () {
              $(".one").attr("checked",false);
            }
         );

         //查询详情
        $(document).on("click",".upd",function(){
            var cid = $(this).attr("value")
            $.ajax({
               type: "GET",
               url: "<?php echo Url::to(['user/morerank']) ?>",
               data: "cid="+cid,
               beforeSend: function(){
                     //  $("#loading").show();
                    },
               complete: function(){
                     //  $("#loading").hide();
                    },
               success: function(msg){
                     if( msg['code'] == '200'){
                            $("#show").html(msg['data'])
                        }else if(msg['code'] == '400'){
                            alert('失败')
                        }else if(msg['code'] == '403'){
                            alert('暂无权限')
                        }
                        //开启遮罩层
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
            $.get("<?php echo Url::to(['user/vipstatus'])?>",{cid : $(this).attr("value"),status : status},function(data){
                if( data['code'] == '200' ){
                     //修改成功
                    }else if( data['code'] == '400' ){
                        alert('修改状态失败')
                    }else if( data['code'] == '403' ){
                        alert('暂无权限')
                    }
              })
        })

		//添加提示
		buer = $("#errorfix").val()
		  //alert(buer)
		if (buer) {
		   layer.msg(buer)
		};

    $(".exp").click(function(){
      location.href = "<?= Url::to(['user/vip-info'])?>";
    })

    })
</script>
