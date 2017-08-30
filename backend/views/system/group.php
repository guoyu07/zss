<?php
use yii\helpers\Html;
$this->title = '轮播组管理';
?>

<style>
label{
	display:none;
}
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
#show{display: none;  position: absolute;  top: 10%;  left: 10%;  width: 60%;  height: 82%;  padding: 8px;  border: 8px solid #E8E9F7;  background-color: white;  z-index:1002;  overflow: auto;}   
img{cursor:pointer;}
#bg{ display: none; position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}  

</style>



<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>轮播组管理</h5>
          </div>


        <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
        <div id="searchdiv">
             <!--start-top-serch-->  
             <div id='bt1'>
                <a   href='<?php echo Yii::$app->urlManager->createUrl(['system/groupadd']);?>'><button class='btn btn-primary'>添加</button></a>&nbsp;&nbsp;<button class='btn1 btn btn-info'>删除</button>&nbsp;&nbsp;
                <button class='che btn btn-info'>全选</button>
             </div>
            <div id="search">   
             
                    <input type="text" placeholder="搜索轮播组名..." id="word"/>
                    <button  class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
            </div>
            <!--close-top-serch-->
        </div>

          <div class="widget-content nopadding">
         
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                    <th></th>
                    <th>轮播组ID</th>
                  <th>轮播组名</th>
                   <th>轮播组速度(秒)</th>
                    <th>轮播组状态</th>
                   <th>轮播组开始时间</th>
                  <th>轮播组结束时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody id='tbody'>
              	<?php foreach ($group as $gk=>$gv):?>
              	<tr>
              		<td><input type="checkbox" class='one' value="<?= Html::encode($gv['group_id']);?>" isshow="<?= Html::encode($gv['group_show']);?>"></td>
              		<td><?= Html::encode($gv['group_id']); ?></td>
              		<td><?= Html::encode($gv['group_name']); ?></td>
              		<td><?= Html::encode($gv['group_ctime']); ?></td>
              		<td><?php if(Html::encode($gv['group_show'])){?><img class="status" style="cursor:hand" gk="<?php echo $gk;?>" val="<?= Html::encode($gv['group_id']);?>" status="<?= Html::encode($gv['group_show'])?>"  src="<?php yii::$app->request->baseUrl;?>assets/ico/png/34.png" width="20" height="20"/><?php }else{?><img src="<?php yii::$app->request->baseUrl;?>assets/ico/png/40.png"  class="status" gk="<?php echo $gk;?>" style="cursor:hand" val="<?= Html::encode($gv['group_id']);?>" status="<?= Html::encode($gv['group_show'])?>" width="20" height="20"/><?php } ?></td>
              		<td><?= Html::encode(date('Y-m-d H:i:s',$gv['group_start']));?></td>
              		<td><?= Html::encode(date('Y-m-d H:i:s',$gv['group_end']));?></td>
              		<td><a href="<?php echo Yii::$app->urlManager->createUrl(['system/groupdetail']);?>&&did=<?= Html::encode($gv['group_id']);?>"><img class="detail" src="<?php yii::$app->request->baseUrl;?>assets/order/search.png" width='20' height='20'></a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="<?php echo Yii::$app->urlManager->createUrl(['system/groupupdate']);?>&&gid=<?php echo $gv['group_id']?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/actions/edit.png"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a  href="javascript:void(0)" class="del" id="d<?= Html::encode($gv['group_id']);?>" value="<?= Html::encode($gv['group_id']);?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/actions/delete.png"/></a></td>
              	</tr>
              	<?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
        
        <div style="display:none">
    <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体"></table>
</div>
<script>
   
    $(function(){
    	//全选
        $(".che").toggle(
           function () {
             $(".one").attr("checked",true);
           },
           function () {
             $(".one").attr("checked",false);
           }
         );

         //搜索
         $(document).on("click",".tip-bottom",function(){
             var search = $("#word").val();

             var search_str = "";
             $.getJSON("<?php echo Yii::$app->urlManager->createUrl(['system/findgroup']);?>",{search : search},function(data){

 				if(data == 0){
 					search_str +="<tr><td colspan='9'>搜索无结果</td></tr>";
 				}else if(eval(data).length>0){

 					for(var i=0;i<eval(data).length;i++){
 						search_str += "<tr class='gradeX'><td><input type='checkbox' class='one' value="+data[i]['group_id']+"></td><td>"+data[i]['group_id']+"</td><td>"+data[i]['group_name']+"</td><td>"+data[i]['group_ctime']+"</td><td>"+data[i]['group_show']+"</td><td>"+data[i]['group_start']+"</td><td>"+data[i]['group_end']+"</td>";
 			            search_str += "<td><a href='javascript:void(0);'><img class='detail' val='"+data[i]['group_id']+"'  width='20' height='20' src=<?php yii::$app->request->baseUrl;?>assets/order/search.png></a>&nbsp;&nbsp;";
 						search_str += "<a  href='index.php?r=system/groupupdate&&gid='"+data[i]['group_id']+"'><img src=<?php echo Yii::$app->request->baseUrl;?>/assets/actions/edit.png></a>&nbsp;&nbsp";
 			            search_str += "<a  href='javascript:void(0)' class='del' id='d"+data[i]['group_id']+"' value='"+data[i]['group_id']+"'><img src=<?php echo Yii::$app->request->baseUrl;?>/assets/actions/delete.png></a>";
 						search_str += "";
 							search_str += "</td></tr>";
 					}
 			}
 			    $("#tbody").html(search_str)
             })
         })

    	//轮播图切换
		$('.status').click(function(){
			var id = $(this).attr('val');
			var gk = $(this).attr('gk');
			var status = $(this).attr('status');

			if(!status){
				alert('直接点击要展示的轮播图即可完成修改');
				return false;
			}
			//改变状态
			$.get('<?php echo Yii::$app->urlManager->createUrl(['system/statuschange']);?>',{id:id,status:status},function(status){

					if(status == 1){
					$('.status').attr("src","<?php yii::$app->request->baseUrl;?>assets/ico/png/40.png");
					$('.status').attr("status",0);

					$('.status').eq(gk).attr("src","<?php yii::$app->request->baseUrl;?>assets/ico/png/34.png");
					$('.status').eq(gk-1).attr("status",1);
					layer.msg('轮播图更换成功', {icon: 1});
				}else{
					layer.msg('不可直接修改启用中轮播组状态', {icon: 2});
				}
			});
		});

    	//展开展出
        $("#small").toggle(function(){
            $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
          },function(){
            $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        });


        
        //删除弹窗
        $(document).on("click",".del",function(){
            var gid = $(this).attr("value")
	//询问框
            layer.confirm('您确定要删除吗？', {
              btn: ['删除','取消'] //按钮
            }, function(){ 
                $.get("<?php echo Yii::$app->urlManager->createUrl(['system/del']);?>",{gid:gid},function(data){
                    if( data == 1 ){
                       layer.msg('该轮播组删除成功', {icon: 1});
                       $("#d"+gid).parent().parent().remove();
                    }else if(data == 2){
                        layer.msg('轮播组正在使用中,请先切换至其他轮播组再进行此操作', {icon: 0});
                    }else if(data == 3){
                        layer.msg('该组轮播图下还有轮播图,请删除轮播图再进行此操作', {icon: 0});
                    }else if(data == 0){
                    	layer.msg('网络故障,删除失败', {icon: 0});
                    }
                })
              
            }, function(){
                    //取消执行
            });
        });



        //批量删除
        $(document).on("click",".btn1",function(){
            var one = $(".one:checked")
            if(one.length <= 0){
				alert('请选择要删除的轮播组');
	            return false;
	        }

            var gid = [];
            var show = [];
             one.each(function(){
                gid.push($(this).val())
                show.push($(this).attr('isshow'))
             })
             show = show.join(',');
             gid = gid.join(',')
             
                                　　var sear=new RegExp(1);
                                　　if(sear.test(show))
                                　　{
                layer.msg('启用状态的轮播组不能被删除', {icon: 2});
                                　　	return false;
                                　　}

             //询问框
            layer.confirm('您确定要全部删除吗？', {
              btn: ['确定','取消'] //按钮
            }, function(){ 
                $.get("<?php echo Yii::$app->urlManager->createUrl(['system/delcheck']);?>",{gid : gid},function(data){
                    if( data['code'] == '200' ){
                       layer.msg('删除成功', {icon: 1});
                       location.reload()
                    }else{
                       layer.msg('删除失败', {icon: 0});
                    }
                })
              
            }, function(){
                    //取消执行
            });
            
         })
    })
    
    function hidediv() {  
        	$("#bg").hide();
        	$("#show").hide();
        }
</script>
