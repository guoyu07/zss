<?php 
namespace frontend\controllers;

use yii;

use yii\base\Controller;
use frontend\models\Zssuser;


/*
 * 微信接入模块
 * */
class WeixinController extends Controller{


	public  $enableCsrfValidation = false;

    public function actionIndex(){

		@$echoStr = $_GET["echostr"];
        @$signature = $_GET["signature"];
        @$timestamp = $_GET["timestamp"];
        @$nonce = $_GET["nonce"];
        $token = 123456;
        @$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature )
		{
            echo $echoStr;
        }
		
		echo $this->reponseMsg();
	}

	//创建菜单
		function actionCreateMenu(){
		$access_token = $this->getAccessToken();
		$data = '
		{
		    "button": [
		        {
		            "name": "点我", 
		            "sub_button": [
		                {
		                    "type": "click", 
		                    "name": "积分换礼", 
		                    "key": "1100"
		                }, 
		                {
		                    "type": "click", 
		                    "name": "门店信息", 
		                    "key": "3100"
		                }, 
		                {
		                    "type":"view", 
		                    "name": "宅食新闻", 
		                     "url":"http://www.profect.site:83/"
		                }
		            ]
		        }, 
		        {
		            "name": "点餐", 
		            "sub_button": [
		                {
		                    "type":"view", 
		                    "name": "会员中心", 



		                    "url":"http://wx.zss365.com/web/index.php?r=third/"

		                }, 
		                {
		                    "type": "click", 
		                    "name": "点餐攻略", 
		                    "key": "2101"
		                }, 
		                {
		                    "type":"view",
		                    "name": "点餐", 


		                    "url":"http://wx.zss365.com/web/index.php?r=third/shop/"

		                }
		            ]
		        }, 
		        {
		            "name": "用户反馈", 
		            "sub_button": [
		                {
		                    "type":"view",
		                    "name": "点评", 


		                    "url":"http://www.wujiaweb.com/web/index.php?r=pay/"

		                }
		               
		            ]
		        }
		    ]
		}';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		echo $access_token;die;
		if (curl_errno($ch)) {
		  return curl_error($ch);
		}

		curl_close($ch);
		echo  $tmpInfo;
		}


	public function reponseMsg(){
		$session = Yii::$app->session;
		$model = new Zssuser();
		
		//1.获取到微信推送过来的post数据(XML格式)
		$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
		//2.处理消息类型,并设置回复类型和内容
		$postObj = simplexml_load_string( $postArr );
		$toUser   = $postObj->FromUserName;
		$fromUser = $postObj->ToUserName;
		
		define("username","$toUser",TRUE);	
		//判断该数据包是否是订阅的事件推送
		if( strtolower( $postObj->MsgType ) == 'event'){
		    
        switch ($postObj->Event)
        {
                case "subscribe":
                $content = "欢迎进入宅食送微信平台";
                break;
                case "LOCATION":
                    $xy['x'] = $postObj->Latitude;
                    $xy['y'] = $postObj->Longitude;
                break;
				case "CLICK":
					switch ($postObj->EventKey)
				{
					case "1100":		
					 $session->set('username', "$toUser");	
					 //$language = $session->get('username');
					 						
					$content = "积分换大礼开发中敬请期待";			
					break;
					case "3100":
					$allinfo = $model->allshop($toUser );
					$content = "$allinfo";					
					break;
					case "2101":
					$content = "你点击点餐攻略";
					break;
				}	
                break;
			   	case "VIEW":
                break;

           }
		}		
		 		
				$allinfoT = $content;
				$time = time();
				$msgType  = 'text';
				//  = "欢迎加入微信开发测试test\n回复数字1~4查看简绍";
				$template = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
				$info     = sprintf($template,$toUser,$fromUser,$time,$msgType,$allinfoT);
				return  $info;
		
	}

	 private function getAccessToken() {
		$AppId = "wx658b45266bb52cd1";
		$AppSecret = "62016b5966e512dbad9ecd957f66e9cb";

		 $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$AppId."&secret=".$AppSecret;
		 $data =$this->getCurl($url);//通过自定义函数getCurl得到https的内容
		 $resultArr = json_decode($data, true);//转为数组
		 return $resultArr["access_token"];//获取access_token
 	}

	 function getCurl($url){//get https的内容
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL,$url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//不输出内容
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		 $result =  curl_exec($ch);
		 curl_close ($ch);
		 return $result;
	 }

	 public function actionInsertto(){

	 	$model = new Zssuser();

	 	$model->insertweixin("123");

	 }
	 
	 public function Memcache($toUser,$xy){
	     yii::$app->cache->set("$toUser", json_encode($xy));
	     return yii::$app->cache->get($toUser);
	 }
}