<?php 
namespace frontend\controllers;

//use common\pay\lib\SDKRuntimeException;
//use common\pay\lib\WxPaypubconfig;
//use common\pay\lib\WxPayPubHelper;
//use common\pay\lib\UnifiedOrderpub;
//use common\pay\lib\NOtifypub;
//use common\pay\lib\Wxpayserverpub;
//use common\pay\lib\Wxpayclientpub;
//use common\pay\lib\Wxpay_client_pub;

use Yii;
use yii\web\Controller;
use \pay\wxpay\Wxpay;

use frontend\controllers\BaseController;
use frontend\models\Zssuser;



/*
 * 个人红包模块 代金券
 * */
class WeixinpayController extends BaseController {

    public function actionIndex() {
    

		$info = $_GET['order_info'];
		
		 //print_r($info);die;
		// $infot = explode(",",$info);
		// $id = base64_decode($infot[0]);
		// $order = base64_decode($infot[1]);
		// $money = base64_decode($infot[2]);
		//print_r($last);die;	
        // jsapi支付
        //$this->redirect('http://www.wujiaweb.com/weixinpay/example/jsapi.php');
		//echo 1;die;
          $www = $_SERVER['HTTP_HOST'];
		setcookie("order_info","$info",time()+3600,"/","$www",0); 
        
		header("location:/weixinpay/example/jsapi.php");

        // // 扫码支付
        // include_once '../pay/wxpay.php';
        // $wx = new Wxpay();
        // $order_info['goods_name'] = "123313133";  
        // $order_info['order_sn'] = '100' . time();
        // $order_info['order_amount'] = 100;
        // $order_info['id'] = time();
        // $wx->do_wxpay($order_info,$openid);
    }

	 public function actionIndext() {
    
		
		$info = $_GET['order_info'];
		
		setcookie("order_info","$info",time()+3600,"/","www.wujiaweb.com",0); 
		header("location:/weixinpay/example/jsapit.php");
	 
	 }

    //同步回调
    function actionReturnback() {
        echo 123;
    }

    //异步回调
    function actionPay_notify() {
        
    }

    //跳转
    function  actionAj_getsingleorder()
    {

    }
   
//获取微信端 openid

 public function getopenid($appid,$secret,$code){


         $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';  
              
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$get_token_url);  
            curl_setopt($ch,CURLOPT_HEADER,0);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
            $res = curl_exec($ch);  
            curl_close($ch);  
            $json_obj = json_decode($res,true);  
  
//根据openid和access_token查询用户信息  
            $access_token = $json_obj['access_token'];  
            $openid = $json_obj['openid']; 

            return $openid; 
 }


public function actionAddress(){
        $appid = "wxa30af7dbdde547b8";
        $secret = "532f76adb7e282990a4db46560fd5683";
           header("location:/adress/address.php");
 

          
    }

public function actionPayerror(){

        $appid = "wxa30af7dbdde547b8";
        $secret = "532f76adb7e282990a4db46560fd5683";

        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". $appid."&secret=".$secret ;
        $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
        //echo $res;
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $access_token = $result['access_token'];
        $openid =$_COOKIE["openid"];
        $time = date("Y-m-d h:i:s",time());
        $content = "订单支付状态\n".$time."\n你好你已经成功下单取单号是12112111211\n订单号是454554554545\n订单状态：失败\n时间：".$time."\n感谢你对宅食送的支持！";

    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
    $data = "{
    \"touser\":\"$openid\",
    \"msgtype\":\"text\",
    \"text\":
    {
         \"content\":\"$content\"
    }
}";
    $allinfo = $this->https_post($url,$data);
    if($allinfo["errmsg"]=="ok"){

        //消息推送成功 执行其他操作

        }else{

            //消息推送失败 执行其他操作

        }


}



public function https_post($url,$data){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);  
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);  
    curl_setopt($curl, CURLOPT_POST,1); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl); 
    if (curl_errno($curl)) {
         return 'Error'.curl_errno($curl);
     } 

    curl_close($curl);
    $resultt = json_decode($result,true);
    return $resultt; 
}


}


