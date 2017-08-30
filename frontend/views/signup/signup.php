<?php 
use yii\helpers\Html;
?>
<!doctype html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="css/style.css" media="all">

<title>宅食送-下单-注册</title>
</head>

<body>
<?php if($flash = Yii::$app->session->getFlash('error')) {
            echo "<script>alert(".$flash.")</script>";

 } ?>

<?php if($flash = Yii::$app->session->getFlash('success')){

         echo "<script>alert(".$flash.")</script>";
      
 } ?>
	<div class="content" style="margin-top:70px;">
    <form method="post">
    <input type="hidden" id="tt" name="_csrf" value="<?php echo \Yii::$app->request->getCsrfToken() ?>">

    	<div style=" background:#fff; height:55px; border-bottom:1px solid #f3f3f3; line-height:55px; ">
        	<input placeholder="请输入手机号码" style="margin-left:30px; line-height:30px; width:60%; outline:none; border:2px solid #81181d; " name="UserForm[user_phone]" id="getnumber">
            <a disabled="false" id="yz" href="javascript:void(0)"><span style="padding:10px 10px; background:#81181d; border:none; color:#fff;" id="getyanzm" class="mk">获取验证码</span></a>
        </div>
        <div style=" background:#fff; height:55px; border-bottom:1px solid #f3f3f3; line-height:55px; ">
        	<input placeholder="请输入验证码"style="margin-left:30px; line-height:30px; width:60%; outline:none; border:2px solid #81181d; " name="UserForm[yanz]" id="content">
            

        </div>
        <div style=" height:35px; background:#fff;">
        	<p style="font-size:9px; margin-left:30px; line-height:35px; color:#707070;">未注册过的手机号码将自动创建为宅食送用户</p>

            </div>
        <button id="subbutton" style="width:100%; height:35px; background:#81181d; border:none; color:#fff;">登陆</button>
        <input type="checkbox" checked style=" margin-left:30px; "  value="1" name="UserForm[xyi]"><label style="line-height:20px; font-size:9px;">宅食送用户协议</label>
          <font color="red"><?= Html::error($model,'user_phone')?><?= Html::error($model,'yanz')?></font>
       </form> 
    </div>

<script>
$(function(){
    $("#getyanzm").click(function(){
        number = $("#getnumber").val();
        tt = $("#tt").val();
       
        if (number==""||number.length!=11) {
            alert("手机号格式不对")
            return false;
        };
        $("#getnumber").attr("id","abc")
        
        
         $.ajax({
                 type: "POST",
                 url: "<?= yii::$app->urlManager->createUrl(['signup/yanzm'])?>",
                 data: {_csrf:tt,number:number},
                 success: function(msg){
                   if(msg){
                    setInterval(fun,1000);
                   }else{
                    alert("发送验证码失败！点击重新发送");
                   }

                 }
               })
    })
$("#subbutton").click(function(){
    number = $("#getnumber").val();
    content = $("#content").val();
        if (number==""||number.length!=11) {
            alert("手机号格式不对")
            return false;
        };
        if (content=="") {
            alert("请输入验证码")
            return false;
        };

})


i=60;

function fun(){
              i--; 
               if (i<=0){
                $(".mk").html("获取验证码");
                $(".mk").attr("calss","mo")
                $("#abc").attr("id","getnumber")
                return false;
               }else{    
              $(".mk").html(i+"秒后点击重发");
          }
              
         
    }
})
</script>



</body>
</html>
