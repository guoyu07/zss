<?php 
namespace frontend\controllers;

use yii;

use frontend\controllers\BaseController;
use frontend\models\UserForm;
use frontend\models\Zssuser;

/*
 * 用户注册模块
 * */
class SignupController extends BaseController{
	
	public function actionIndex(){



			//$code = $_GET["code"]; 
			
			@$openid = $_COOKIE["openid"];

			$model = new UserForm();



			if ($model->load(yii::$app->request->post())&&$model->validate()) {
			
			$mobile  = yii::$app->request->post("UserForm")["user_phone"];
			
			$content = yii::$app->request->post("UserForm")["yanz"];

			//$cookie = $this->cookies();

			   $yanzma = strtolower($_COOKIE["username"]);//不区分大小写

			if($content!=$yanzma){

             Yii::$app->session->setFlash('error', '验证码不正确');
           
             //$cookie->remove("username");//删除cookie

			}else{

			 $models = new Zssuser();

			 $allinfo = $models->adduser($mobile,"$openid"); 
			 
			 if ($allinfo) {

			   Yii::$app->session->setFlash('success', '注册成功');

			  //	return $this->redirect(['index/index']);die;
			    //$this->redirect(array('step/show'));
			  header("Location:index.php?r=index");
			 }
	         //$cookie->remove("username");//删除cookie

			}


			}

			
            
		   return $this->render('signup',["model"=>$model]);

	}

	//短信发送
	public function actionYanzm(){
		$mobile = yii::$app->request->post("number");

		$value = $this->GetRandStr(4);

		$content = "【宅食送】验证码：$value"."一分钟内有效";

		$ch = curl_init();
		    $url = "http://apis.baidu.com/kingtto_media/106sms/106sms?mobile=$mobile&content=$content";
		    $header = array(
		        'apikey:b0ffa46739b9bd8b23730be365015bbc',
		    );
		    // 添加apikey到header
		    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    // 执行HTTP请求
		    curl_setopt($ch , CURLOPT_URL , $url);
		    $res = curl_exec($ch);
		    if ($res) {

		    	 //$this->setCookie("username",$value,$expire = 0);
		    	 $www = $_SERVER['HTTP_HOST'];
				// setcookie("username","$value",time()+360000,"/","$www",0);
		    	setcookie("username",$value);
		    	echo true;
		    }else{
		    	$www = $_SERVER['HTTP_HOST'];
				 setcookie("username","$value",time()+360000,"/","$www",0); 
		    	echo false;
		    }


	}			

  		


}

