<?php 
namespace frontend\controllers;

use yii;



use frontend\controllers\BaseController;
use frontend\models\Zssuser;


/*
 * 微信接入模块
 * */
class ThirdController extends BaseController{


	

    public function actionIndex()
	{
	
	if(empty($_SESSION['user'])){  
   
   $appid = "wxa30af7dbdde547b8";
    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://wx.zss365.com/web/index.php?r=user&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
    header("Location:".$url);
	}
	}


    public function actionShop()
	{
		
		if(empty($_SESSION['user'])){  

   $appid = "wxa30af7dbdde547b8";
    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://wx.zss365.com/web/index.php?r=index&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
    header("Location:".$url);
	}

	}	


	public function actionPay()
	{
		
		if(empty($_SESSION['user'])){  
	
   $appid = "wxa30af7dbdde547b8";
    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://wx.zss365.com/web/index.php?r=weixinpay/address&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
    header("Location:".$url);
	}

	}	

	



}