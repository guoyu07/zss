<?php
use yii\helpers\Html;
$this->title = '充值管理';
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
#show{display: none;  position: absolute;  top: 15%;  left: 20%;  width: 50%;  height: 60%;  padding: 8px;  border: 8px solid #E8E9F7;  background-color: white;  z-index:1002;  overflow: auto;}   
#bg{ display: none; position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}  
tr{
	height:30px;
}
</style>
<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>充值管理</h5>
          </div>
        <div id="small" value="0"><h5 id="smallfont">展&nbsp;&nbsp;&nbsp;开</h5></div>
        <div id="searchdiv">
             <!--start-top-serch-->  
             <div id='bt1'>
                <button class='btn btn-primary' onclick="showdiv()">添加</button>&nbsp;&nbsp;<button class='btn1 btn btn-info'>删除</button>
                &nbsp;&nbsp;<button class='che btn btn-info'>全选</button>
             </div>
            <div id="search">   
             
                    <input type="text" placeholder="搜索充值金额..." id="word"/>
                    <button  class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
            </div>
            <!--close-top-serch-->
        </div>
          
          
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" style="overflow:scroll; font-size:15px;font-family:楷体">
              <thead>
                <tr>
                    <th></th>
                    <th>充值排序</th>
                  <th>充值金额</th>
                  <th>赠送金额</th>
                   <th>创建时间</th>
                   <th>上次修改时间</th>
                   <th>上次修改人</th>
                  <th>操作</th>
                </tr>
              </thead>
				<tbody id='tbody'>
                  <?php foreach($redata as $gv):?>
                  <tr class="gradeX" >
                      <td><input type="checkbox" class='one' value="<?= Html::encode($gv['rebate_id']);?>"></td>
                      <td><?= Html::encode($gv['rebate_id']);?></td>
                      <td><?= Html::encode($gv['rebate_price']) ?></td>
                     <td><?= Html::encode($gv['rebate_send']);?></td>
                     <td><?= Html::encode(date('Y-m-d H:i:s',$gv['created_at']));?></td>
                      <td><?= Html::encode(date('Y-m-d H:i:s',$gv['updated_at']));?></td>
                      <td><?= Html::encode($gv['username']);?></td>
                      <td><a  href="index.php?r=system/rechargeedit&&id=<?= Html::encode($gv['rebate_id']);?>" ><img  src="<?php echo Yii::$app->request->baseUrl;?>/assets/order/edit.png" alt="编辑" title="编辑"/>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a  href="javascript:void(0)" class="del" id="d<?= Html::encode($gv['rebate_id']);?>" value="<?= Html::encode($gv['rebate_id']);?>"><img src="<?php echo Yii::$app->request->baseUrl;?>/assets/actions/delete.png"/></a></td>
                    </tr>
                  <?php endforeach;?>
                  </tbody>
            </table>
          </div>
            <div style="display:none">
    <table class="table table-bordered data-table"  style="overflow:scroll; font-size:15px;font-family:楷体"></table>
</div>
        </div>
        <!--遮罩层-->
<div id="bg"></div>
<div id="show">
	
</div>
<script>



    //弹出遮罩层显示数据
    function showdiv() {

        	$.ajax({
            	url:'index.php?r=system/rechargeadd',
        		async:false,
        		type:'GET',
        		success:function(data){
					if(data){
						$('#show').html(data)
					}else{
						$('#show').html('数据丢失')
					}
            	}
            });
            
    		$("#bg").show();
    		$("#show").show();
    	}
    
    function hidediv() {
    		msg = $("#addRole").html();
    		$("#bg").hide();
    		$("#show").hide();
    }


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

    	//展开展出
        $("#small").toggle(function(){
            $("#smallfont").html("收&nbsp;&nbsp;&nbsp;起");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
          },function(){
            $("#smallfont").html("展&nbsp;&nbsp;&nbsp;开");
            $("#searchdiv").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        });

        
        //批量删除
        $(document).on("click",".btn1",function(){
            var one = $(".one:checked")
            if(one.length <= 0){
				alert('请选择要删除的轮播组');
	            return false;
	        }
            
            var rid = [];
             one.each(function(){
                rid.push($(this).val())
             })
             rid = rid.join(',')
             //询问框
            layer.confirm('您确定要全部删除吗？', {
              btn: ['确定','取消'] //按钮
            }, function(){ 
                $.get("<?php echo Yii::$app->urlManager->createUrl(['system/rechargedelcheck']);?>",{rid : rid},function(data){
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
         
         //搜索
        $(document).on("click",".tip-bottom",function(){
        	layer.msg('查询中，请稍等......', {icon: 1});
            var search = $("#word").val();
            var search_str = "";
            $.getJSON("<?php echo Yii::$app->urlManager->createUrl(['system/findrecharge']);?>",{search : search},function(data){
				if(data == 0){
					search_str +="<tr><td colspan='9'>搜索无结果</td></tr>";
				}else if(eval(data).length>0){
					for(var i=0;i<eval(data).length;i++){
						search_str += "<tr class='gradeX'><td><input type='checkbox' class='one' value="+data[i]['rebate_id']+"></td><td>"+data[i]['rebate_id']+"</td><td>"+data[i]['rebate_price']+"</td><td>"+data[i]['rebate_send']+"</td><td>"+data[i]['created_at']+"</td><td>"+data[i]['updated_at']+"</td><td>"+data[i]['username']+"</td> <td><a  href='index.php?r=system/imageedit&&id='"+data[i]['rebate_id']+"' ><img  src=<?php echo Yii::$app->request->baseUrl;?>/assets/order/edit.png alt='编辑' title='编辑'/>&nbsp;&nbsp;&nbsp;&nbsp;<a  href='javascript:void(0)' class='del' id='d"+data[i]['rebate_id']+"' value='"+data[i]['rebate_id']+"'><img src=<?php echo Yii::$app->request->baseUrl;?>/assets/actions/delete.png></a></td></tr>";
					}
				}
			    $("#tbody").html(search_str)
            })
        })
         

        //删除弹窗
        $(document).on("click",".del",function(){
            var rid = $(this).attr("value")
			//询问框
            layer.confirm('您确定要删除吗？', {
              btn: ['删除','取消'] //按钮
            }, function(){ 
                $.get("<?php echo Yii::$app->urlManager->createUrl(['system/rechargedel']);?>",{rid:rid},function(data){
					if(data == 2){
						 layer.msg('删除对象不存在', {icon: 2});
					}else if( data == 1 ){
                       layer.msg('删除成功', {icon: 1});
                       $("#d"+rid).parent().parent().remove();
                    }else if(data == 0){
                        layer.msg('网络原因，删除失败', {icon: 0});
                    }else{
                   	 layer.msg('非法操作，请注意', {icon: 2});
                    }
                })
              
            }, function(){
                    //取消执行
            });
        });
    })
    
   /* function hidediv() {  
    	$("#bg").hide();
    	$("#show").hide();
    } */
    
    
</script>
