<?php 
namespace frontend\controllers;

use yii;
use frontend\controllers\BaseController;
use app\models\Carousel;
use app\models\ShopMenu;
use app\models\Order;
use frontend\models\Weixin;
use app\models\Shop;
use frontend\models\Cart;
use frontend\models\Order\Orderinfo;
use yii\helpers\VarDumper;


header("Content-Type:text/html;   charset=utf-8");
class IndexController extends BaseController{
    
    /*
     * 显示首页
     * */
    public function actionIndex(){
        $re = $this->getSignPackage();
        @$code = $_GET["code"]?trim($_GET["code"]):0;
    
        $shop = new Shop();
        $shop_data = $shop->AllShop();
    
        $appid = "wxa30af7dbdde547b8";
        $secret = "532f76adb7e282990a4db46560fd5683";
         
        //获取token
        $token= $this->gettoken($appid, $secret);
    
        //获取openid
        if ($code == 0) {
            @$openid = $this->getopenid($appid,$secret,$code);
            $www = $_SERVER['HTTP_HOST'];
            setcookie("openid","$openid",time()+3600*24*7,"/","$www",0);
        } else{
            @$openid = $_COOKIE["openid"];
        }
    
        yii::$app->cache->delete('code');
        if(!(yii::$app->cache->exists('code'))){
            yii::$app->cache->set('code', $code);
        }
        return $this->render('shop',array('shop'=>$shop_data,'signPackage'=>$re));
    }
    
    
    /*
     * 跳转后
     * */
    public function actionRun(){
        $code = yii::$app->cache->get('code');
        $appid = "wxa30af7dbdde547b8";
        $secret = "532f76adb7e282990a4db46560fd5683";
       
	    //获取token
		$token= $this->gettoken($appid, $secret);
		//获取openid
		$openid = $this->getopenid($appid,$secret,$code);
		
		//对门店进行由近至远的排序
		$shop_id = isset($_GET['shop'])?trim($_GET['shop']):0;

		if($shop_id == 0){
		    $best_shop = 1;
		}else{
		    $shop_all = explode(',',$shop_id);
		    $best_shop = $shop_all[0];
		    unset($shop_all[0]);
		}
		
		//判断是否是注册用户
		$weixin = new Weixin();
		$user_status = $weixin->Isuser($openid);
		$www = $_SERVER['HTTP_HOST'];
		setcookie("openid","$openid",time()+360000000,"/","$www",0);
        
        $new_carousel = new Carousel();
        $carousel_new_info = $new_carousel->GetNewCarousel();
        
        //获取本店新品菜数据
        $shop_menu = new ShopMenu();
        $shop = new Shop();
        
        $uid = isset($_COOKIE['user_id'])?$_COOKIE['user_id']:0;
        //if(!$uid){ $this->error('请先注册',['signup/index']);}
       
        $cart = new Cart();
        $cart_data = $cart->findByUser($uid,$best_shop); 
        $shop_menu_count = $shop_menu->GetShopCount($best_shop);
        
        if(!$shop_menu_count){//如果最近门店没有数据的话,那么就会按照顺序查找到有数据的一个门店id作为最佳的门店id
            $shop_all = array();
            foreach($shop_all as $sk=>$sv){
                
                $shop_menu_count = $shop_menu->GetShopCount($sv);
                $arr .= "----".$shop_menu_count;
                if($shop_menu_count){
                    $best_shop = $sv;
                    break;
                }
            }    
        }
        
        if(!$shop_menu_count){$best_shop = 1;}
        
        //获取门店名称
        $shopdata['name'] = $shop->ShopOne($best_shop)?$shop->ShopOne($best_shop):'门店不存在';
        $shopdata['best'] = $best_shop;
        
        $shop_menu_oldinfo = $shop_menu->GetShopMenu($best_shop);
        $shop_menu_info = $this->assoc_unique($shop_menu_oldinfo[0], 'menu_id');
        //shop_menu_info是新品数据
        //热卖商品的数据需要从订单表中计算订单的数量,从而确定热卖商品的ID号,热卖商品的条件是数量大于50的前三条
        /*$orderinfo = new Orderinfo();
        $shop_hot_info = $orderinfo->HotInfo($best_shop,$shop_menu_oldinfo[1]);
        $serimg = $shop_hot_info[1];
        
        //热卖和新品与购物车中商品融合
        if(!($best_shop == 1)){
             
            if($shop_hot_info && $cart_data[0]){
                $cartall['hot'] = $cart->ShopCart($shop_hot_info[0],$cart_data[0]);
                $newarray[] = "'热卖'";
            }else{
                if($shop_hot_info){
                    $cartall['hot'] = $shop_hot_info[0];
                    $newarray[] = "'热卖'";
                }
            }
        
            if($shop_menu_info && $cart_data[-1]){
                $cartall['shop'] = $cart->ShopCart($shop_menu_oldinfo[0],$cart_data[-1]);
                $newarray[] = "'新品'";
            }else{
                if($shop_menu_info){
                    $cartall['shop'] = $shop_menu_oldinfo[0];
                    $newarray[] = "'新品'";
                }
            }
        }else{
            $cartall['shop'] = $shop_menu_oldinfo[0];
            $cartall['hot'] = $shop_hot_info[0];
        }*/
        
        //if(is_array($cart_data[0])){unset($cart_data[0]);}
       // if(is_array($cart_data[-1])){unset($cart_data[-1]);}
        
        //获取本店菜品分类数据
        $series_info = $shop_menu->GetMenuAll($best_shop,$cart_data);
        if($series_info){ 
            foreach($series_info as $k=>$v){
                $series_new_info[$k]['series_id'] = $v['series_id'];
                $series_new_info[$k]['series_name'] = $v['series_name'];
				$series_new_info[$k]['series_img1'] = $v['series_img1'];
				$series_new_info[$k]['series_img2'] = $v['series_img2'];
                $series_new_info[$k]['series_img3'] = $v['series_img3'];
                $series_new_info[$k]['series_name2'] = $v['series_name2'];
                $series_new_info[$k]['series_desc'] = $v['series_desc'];
                $series_new_info[$k]['series_data'] = $this->assoc_unique($series_info[$k]['series_data'], 'menu_id');
            }
        }else{
            die('series infos error');
        }
       return $this->render('menu',array('cartall'=>$cartall,'shop'=>$shopdata,'shop_id'=>$best_shop,'user_status'=>$user_status,'carousel'=>$carousel_new_info,'series_info'=>$series_new_info));


    }
    
    /*
     * 清空购物车
     * */
    function actionCartclear(){
        $cart = new Cart();
        $uid = $_COOKIE['user_id']?$_COOKIE['user_id']:0;
        if($uid){
            echo $cart->clearByUid($uid);
        }else{
            echo 0;
        }
    }
    
    
    function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
    
    
   
   /*返回唯一性数组*/
    function assoc_unique($arr, $key)
    {
        $rAr=array();
        for($i=0;$i<count($arr);$i++)
        {
            if(!isset($rAr[$arr[$i][$key]]))
            {
                $rAr[$arr[$i][$key]]=$arr[$i];
            }
        }
        $arr=array_values($rAr);
        return $arr;
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
?>