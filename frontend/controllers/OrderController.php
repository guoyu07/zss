<?php 
namespace frontend\controllers;

use yii;

use yii\base\Controller;

use frontend\models\Order\Order;

use frontend\models\Order\Orderinfo;
class OrderController extends Controller{
		
	
    /**
     *@Action 显示订单
     */
    public function actionIndex()
	{

		$model = new Order;
//		$opne_id = isset($_COOKIE['openid']) ? $_COOKIE['openid'] : false;
//		$user_id = $model -> userID($opne_id); //获取user_id;
//		var_dump($user_id);die;
        $info = yii::$app->request->get();
        if(isset($info["userid"])){

            $user_id = $info["userid"];
            setcookie("userid",$user_id);
        }else{
            $user_id = $_COOKIE["userid"] = 8;
        }

		$models = $model -> userOrder(["zss_user.user_id"=>$user_id]);
		$signPackage = $this->getSignPackage();

        return $this->render('order',[
			"models" => $models,	
			'signPackage' => $signPackage,
			'info' => $user_id,
		]);
    }

	 /**
     *@Action 订单详情
	 *@param $id 订单的id
	 *@des  1 堂食  2 自提  3 外卖
     */
	 public function actionOrderList()
	{
		 $id = \Yii::$app->request->get('id');
		 $model = new Order;
		 $list = $model->OrderList($id); //订单详情

		 $modelinfo = new Orderinfo;
		 $info = $modelinfo -> OrderList($id);
		 $list['info'] = $info;
		 //堂食
		 if($list['delivery_type'] == 1)
		 {
			 Return $this->render('order-detail',[
				 "list" => $list,
			]);
		 }
		 //自取
		 elseif($list['delivery_type'] == 2)
		{
			 Return $this->render('order-detail-t',[
				 "list" => $list,
			 ]);
		}
		//送货
		 elseif($list['delivery_type'] == 3)
		{
			 $distribution = $model->distribution($id);//取得配送员
			 Return $this->render('order-detail-takeout',[
				 "list" => $list,
				 "distribution" => $distribution,
			]);
		}
	}





	public function getSignPackage() {
	 $appId = "wxa30af7dbdde547b8";
     $appSecret = "532f76adb7e282990a4db46560fd5683";
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     =>$appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
	   
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
	   
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
   
    
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
		

    return $ticket;
  }

public function getAccessToken() {
	 $appId = "wxa30af7dbdde547b8";
     $appSecret = "532f76adb7e282990a4db46560fd5683";
		if(!isset($_COOKIE["access_tokent"])){
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$appId&corpsecret=$appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
	  setcookie("access_token");
	  }else{
	  $access_token = $_COOKIE["access_tokent"];
	  }
   return  $access_token;
  }
public function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }









	








}
