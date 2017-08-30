
<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;



?>
<style>



  textarea{  
        border:0;  
        background-color:transparent;  
        /*scrollbar-arrow-color:yellow;  
        scrollbar-base-color:lightsalmon;  
        overflow: hidden;*/  
        color: #666464;  
        height: auto;  
    } 
    #tto td{ text-align:center;} 
</style>
<?php if($flash = Yii::$app->session->getFlash('error')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

<?php if($flash = Yii::$app->session->getFlash('success')) {?>
               <input type="hidden" id="errorfix" value="<?= $flash?>">
<?php  } ?>

 

<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>菜品添加</h5>
          </div>
    <div id="searchdiv">
    <!--time start -->
     <!--   <div id="time">
      <button class="btn btn-inverse">时间范围</button>
      <input type="text" id="start_time"  onclick="laydate()"/>
      <input type="text" id="end_time"  onclick="laydate()"/>
    </div>-->
    <!--time end -->
    <!---->
   
     <button class="btn btn-info" id="retu">返回菜品页</button>
   
    
    <!---->
     <!--start-top-serch-->
  
    <!--close-top-serch-->
    </div>
         <input type="hidden" id="tt" value="<?php echo  \Yii::$app->request->getCsrfToken() ?>">
      

<input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
<div align="center">
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">
<table class="table table-bordered data-table" id="tto" style="overflow:scroll; font-size:15px;font-family:楷体">
<tr>
  <td><span ><b>菜品分类</b></span><br/ ></td>
  <td>
    <select style="overflow:scroll; font-size:15px;font-family:楷体;height:26px;width:300px;" name="MenuForm[series_id]" id="">
       <option value="" selected="selected">----请选择----</option>
      <?php
        foreach ($allser as $key => $value) {?>
          <option  value="<?= $value['series_id']?>"><?= Html::encode($value["series_name"])?></option>
        <?php }
      ?>

    </select>

  </td>
</tr>
<tr>
  <td><span><b>菜品名称</b></span><br/ ></td>
  <td><input type="text" name="MenuForm[menu_name]" placeholder="请填写菜品名称" style="height:26px;width:300px">
   <span><font color="red"><?php echo Html::error($model,'menu_name') ?></font></span>
</td>
</tr>
<tr>
  <td><span><b>菜品价格</b></span><br/ ></td>
  <td>
  
  <input type="text" name="MenuForm[menu_price]" placeholder="请填写正确的菜品价格"  style="height:26px;width:300px">  <span><font color="red"><?php echo Html::error($model,'menu_price') ?></font></span>
</td>
</tr>
<tr>
  <td><span ><b>菜品单位</b></span><br/ ></td>
  <td>
  
  <select style="overflow:scroll; font-size:15px;font-family:楷体;width:300px" name="MenuForm[menu_code]" >
  <option value="">----请选择----</option>
    <option value="份">份</option>
    <option value="碗">碗</option>
    <option value="个">个</option>
    <option value="勺">勺</option>
    <option value="盆">盆</option>
    <option value="厅">厅</option>
    <option value="斤">斤</option>
  </select>
  </td>
</tr>



<tr>
  <td><span><b>菜品图片</b></span><br/ ></td>
  <td>

  
  <div style="">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($modelimg, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*',"id"=>"male"]) ?>
</div>
  </td>
</tr>
<tr>
  <td><span><b>菜品排序</b></span><br/ ></td>
  <td>
  
  <input type="text" name="MenuForm[menu_sort]" placeholder="默认为50，数字越大越靠前"  style="height:26px;width:300px">  <span><font color="red">
 <span><font color="red"><?php echo Html::error($model,'menu_sort') ?></font></span>

</td>
</tr>
<tr>
  <td><span><b>是否在线上显示</b></span></td>
  <td>
  
<div style="height:50px">
 <input type="radio" value="1" checked="checked" name="MenuForm[shop_show]">显示
 <input type="radio" value="0" name="MenuForm[shop_show]">隐藏
 <span><font color="red"><?php echo Html::error($model,'shop_show') ?></font></span>
 </div>
  </td>
</tr>

<tr>
  <td><span><b>菜品介绍</b></span><br/ ><br/ ></td>
  <td>

    <textarea id="myEditor"   name="MenuForm[menu_introduce]" >点击添加</textarea>
     <span><font color="red"><?php echo Html::error($model,'menu_introduce') ?></font></span>
  </td>
</tr>
<tr>
  <td>
  <div class="form-group" style="width:100px">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
</td>
  <td></td>
</tr>
</table>
</form>

</div>




<script src="<?= yii::$app->request->baseUrl?>/add/layer/layer.js"></script>

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
        location.href="<?= yii::$app->urlManager->createUrl(['menu/search'])?>&key="+word;
        
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
   $("#retu").click(function(){

  location.href="<?= yii::$app->urlManager->createUrl(['menu/list'])?>"


   })
});
</script> 

   <script>  
            //拖拽上传开始  
            //-1.禁止浏览器打开文件行为  
            document.addEventListener("drop",function(e){  //拖离   
                e.preventDefault();      
            })  
            document.addEventListener("dragleave",function(e){  //拖后放   
                e.preventDefault();      
            })  
            document.addEventListener("dragenter",function(e){  //拖进  
                e.preventDefault();      
            })  
            document.addEventListener("dragover",function(e){  //拖来拖去    
                e.preventDefault();      
            })  
            //上传进度  
            var pro = document.getElementById('prouploadfile');  
            var persent = document.getElementById('persent');  
            function clearpro(){  
                pro.value=0;  
                persent.innerHTML="0%";  
            }  
              
            //2.拖拽  
            var stopbutton = document.getElementById('stop');  
              
            var resultfile=""  
            var box = document.getElementById('drop_area'); //拖拽区域     
            box.addEventListener("drop",function(e){           
                var fileList = e.dataTransfer.files; //获取文件对象    
                console.log(fileList)  
                //检测是否是拖拽文件到页面的操作            
                if(fileList.length == 0){                
                    return false;            
                }             
                //拖拉图片到浏览器，可以实现预览功能    
                //规定视频格式  
                //in_array  
                Array.prototype.S=String.fromCharCode(2);  
                Array.prototype.in_array=function(e){  
                    var r=new RegExp(this.S+e+this.S);  
                    return (r.test(this.S+this.join(this.S)+this.S));  
                };  
                var video_type=["video/mp4","video/ogg"];  
                  
                //创建一个url连接,供src属性引用  
                var fileurl = window.URL.createObjectURL(fileList[0]);                
                if(fileList[0].type.indexOf('image') === 0){  //如果是图片  
                    var str="<img width='200px' height='200px' src='"+fileurl+"'>";  
                    document.getElementById('drop_area').innerHTML=str;                   
                }else if(video_type.in_array(fileList[0].type)){   //如果是规定格式内的视频                    
                    var str="<video width='200px' height='200px' controls='controls' src='"+fileurl+"'></video>";  
                    document.getElementById('drop_area').innerHTML=str;        
                }else{ //其他格式，输出文件名  
                    //alert("不预览");  
                    var str="文件名字:"+fileList[0].name;  
                    document.getElementById('drop_area').innerHTML=str;      
                }         
                resultfile = fileList[0];     
                console.log(resultfile);      
                  
                //切片计算  
                filesize= resultfile.size;  
                setsize=500*1024;  
                filecount = filesize/setsize;  
                //console.log(filecount)  
                //定义进度条  
                pro.max=parseInt(Math.ceil(filecount));   
                  
                  
                  
                i =getCookie(resultfile.name);  
                i = (i!=null && i!="")?parseInt(i):0  
                  
                if(Math.floor(filecount)<i){  
                    alert("已经完成");  
                    pro.value=i+1;  
                    persent.innerHTML="100%";  
                  <textarea name="" rows="" cols=""></textarea>
                }else{  
                    alert(i);  
                    pro.value=i;  
                    p=parseInt(i)*100/Math.ceil(filecount)  
                    persent.innerHTML=parseInt(p)+"%";  
                }  
                  
            },false);    
              
            //3.ajax上传  
      
            var stop=1;  
            function xhr2(){  
                if(stop==1){  
                    return false;  
                }  
                if(resultfile==""){  
                    alert("请选择文件")  
                    return false;  
                }  
                i=getCookie(resultfile.name);  
                console.log(i)  
                i = (i!=null && i!="")?parseInt(i):0  
                  
                if(Math.floor(filecount)<parseInt(i)){  
                    alert("已经完成");  
                    return false;  
                }else{  
                    //alert(i)  
                }  
                var xhr = new XMLHttpRequest();//第一步  
                //新建一个FormData对象  
                var formData = new FormData(); //++++++++++  
                //追加文件数据  
                  
                //改变进度条  
                pro.value=i+1;  
                p=parseInt(i+1)*100/Math.ceil(filecount)  
                persent.innerHTML=parseInt(p)+"%";  
                //进度条  
                  
                  
                if((filesize-i*setsize)>setsize){  
                    blobfile= resultfile.slice(i*setsize,(i+1)*setsize);  
                }else{  
                    blobfile= resultfile.slice(i*setsize,filesize);  
                    formData.append('lastone', Math.floor(filecount));  
                }  
                    formData.append('file', blobfile);  
                    //return false;  
                    formData.append('blobname', i); //++++++++++  
        　　      formData.append('filename', resultfile.name); //++++++++++  
                    //post方式  
                    xhr.open('POST', "<?= yii::$app->urlManager->createUrl(['Menu/add'])?>"); //第二步骤  
                    //发送请求  
                    xhr.send(formData);  //第三步骤  
                    stopbutton.innerHTML = "暂停"  
                    //ajax返回  
                    xhr.onreadystatechange = function(){ //第四步  
                　　　　if ( xhr.readyState == 4 && xhr.status == 200 ) {  
                　　　　　　console.log( xhr.responseText );  
                            if(i<filecount){  
                                xhr2();  
                            }else{  
                                i=0;  
                            }         
                　　　　}  
                　　};  
                    //设置超时时间  
                    xhr.timeout = 20000;  
                    xhr.ontimeout = function(event){  
                　　　　alert('请求超时，网络拥堵！低于25K/s');  
                　　}           
                      
                    i=i+1;  
                    setCookie(resultfile.name,i,365)  
                      
            }  
              
            //设置cookie  
            function setCookie(c_name,value,expiredays)  
            {  
                var exdate=new Date()  
                exdate.setDate(exdate.getDate()+expiredays)  
                document.cookie=c_name+ "=" +escape(value)+  
                ((expiredays==null) ? "" : ";expires="+exdate.toGMTString()+";path=/")  
            }  
            //获取cookie  
            function getCookie(c_name)  
            {  
            if (document.cookie.length>0)  
              {  
              c_start=document.cookie.indexOf(c_name + "=")  
              if (c_start!=-1)  
                {   
                c_start=c_start + c_name.length+1   
                c_end=document.cookie.indexOf(";",c_start)  
                if (c_end==-1) c_end=document.cookie.length  
                return unescape(document.cookie.substring(c_start,c_end))  
                }   
              }  
            return ""  
            }  
              
              
            function stopup(){  
                if(stop==1){  
                    stop = 0  
                      
                    xhr2();  
                }else{  
                    stop = 1  
                    stopbutton.innerHTML = "继续"  
                      
                }  
                  
            }  
            </script> 
    <script>
  buer = $("#errorfix").val()
  //alert(buer)
  if (buer) {
   layer.msg(buer);
  };
</script>     
