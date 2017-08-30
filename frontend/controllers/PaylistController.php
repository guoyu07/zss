<?php 
namespace frontend\controllers;
use Yii;
use yii\base\Controller;
use app\models\paylist\Add;
use app\models\paylist\Addtable;
use app\models\paylist\Getmenu;
use app\models\paylist\Wallet;
use app\models\paylist\Coupon;
use app\models\paylist\Shop;
use app\models\paylist\ShopMenu;
use app\models\paylist\Subtract;
use app\models\paylist\Order;
use app\models\paylist\User;
use frontend\models\Cart;
use yii\helpers\VarDumper;
/*
 * 列表模块
 * */
class PaylistController extends Controller{

    /*
     * 支付列表1    外卖+配送
     * */
    public function actionPaylist(){
		$string = $_GET['r'];
		$action = substr($string,8);
		setcookie("action_name",$action);
		$openid = $_COOKIE['openid'];		
		
		$order = new Order();
		$user = $order->getuserid($openid);
		if($user){
			$user_id = $user['user_id'];
			setcookie("user_id",$user_id);
		}else{
			echo "get the error information！";die; 
		}		
		$session = Yii::$app->session;
		$userID = $user_id;								//现在登录用户的ID
		$menuId = array();
		$menuId = json_decode($session['user_order'],1); //获取选中的菜品数量及其id
		
		$wallet = New Wallet();						
		$walletInfo = $wallet->getWallet($userID);//查询登录用户的红包 有返回‘1’，没有返回‘0’
		
		$coupon = New Coupon();						
		$couponInfo = $coupon -> getCoupon($userID);	//查询订单里的菜品信息
		
		$subtract = new Subtract();					
		$subtractInfo = $subtract -> getSubtract();//查询满减信息
		
		$menu = new Getmenu();					
		$menuInfo = $menu -> getInfo($menuId);//查询订单里的菜品信息
		
		$shop = new Shop();						
		$shopInfo = $shop -> selectShop($_COOKIE['shop_idinfo']);//查询门店的信息
		
		$user = new User();
		$vipinfo = $user -> getvipinfo($userID);
		
		//$add = new Add();						
		//$addInfo = $add -> selectadd();	
		
		$useraddress = $order -> getAddress($userID);//查询用户添加过的送餐地址信息
		
		$table = new Addtable();
				
		if($_POST)
		{
			$order = new Order();
			$re = $order->addsail(Yii::$app->request->post());
			if($re){
				$request = Yii::$app->request->post();
				 
				$arr["id"] = base64_encode(substr($re,11)); 	//当天第几个订单
				$arr["order"] = base64_encode($re);				//订单号（全）
				$arr["money"]= base64_encode($request['realPrice']*100);//总价单位为分
				$allinfo = implode(",",$arr);
				if($_POST['payonoff'] == "online"){
					$orderprice = $request['realPrice'];	//订单价格
					setcookie('allprice',$orderprice);						
					header("location:/web/index.php?r=weixinpay/index&order_info=$allinfo");//跳转到使用微信支付支付
				} else if($_POST['payonoff'] == "balance"){		//使用账户余额支付
						$orderprice = $request['realPrice'];	//订单价格	
						setcookie('allprice',$orderprice);
						$user = new User();					//实例化user表			
						$user_price = $order -> getpocket($userID);
						$price = $user_price['user_price'];	//用户的余额
						$orderprice=sprintf("%.2f", $orderprice);
						//echo $price."aaa".$orderprice;die;
							if($price < $orderprice){
								echo "<script>alert('余额不足')</script>";
								echo "<script>history.go(-1)</script>";die;
							}
						$upd_price = $user -> updprice($userID,$orderprice);//修改user表中的信息
						if($upd_price){
							header("location:/web/index.php?r=paylist/paysuccess&allprice=$orderprice");//本控制器下的支付成功的方法
						}

					else{
						echo mysql_error;die;
					}
					
				}
				
			}else{
				echo json_encode("0");die;
			}
		}
		
        return $this->render('pay-list',[
		  'model'  	=>$table,	           //传--表单model
		   'menu'   =>$menuInfo,	      //传--选中菜单的信息
		 'wallet' 	=>$walletInfo,       //传--用户是否有红包
		 'coupon'	=>$couponInfo,		//传--用户拥有的优惠券
	   'subtract'   =>$subtractInfo,   //传--满减信息
	   'address' 	=>$useraddress,   //传--地址信息
		'shop' 		=>$shopInfo,   	 //传--门店信息
		'add'		=>$addInfo,		//传--满赠信息
		'vipinfo'	=>$vipinfo	   //传--折扣信息
		]);
    }
    
	
	

	
	
    /*
     * 支付流程2    堂食
     * */
    public function actionPaylist2(){
		$string = $_GET['r'];
		$action = substr($string,8);
		setcookie("action_name",$action);
		
		$openid = $_COOKIE['openid'];
		$order = new Order();
		$user = $order->getuserid($openid);
		if($user){
			$user_id = $user['user_id'];
			setcookie("user_id",$user_id);
		}else{
			echo "get the error information！";die;
		}				
		
		
		
		$session = Yii::$app->session;
		$userID = $user_id;		//现在登录用户的ID
		$menuId = array();
		$menuId = json_decode($session['user_order'],1); //获取选中的菜品数量及其id
		
		
		$wallet = New Wallet();						//实例化红包表的模型
		$walletInfo = $wallet->getWallet($userID);//查询登录用户的红包 有返回‘1’，没有返回‘0’
		
		$coupon = New Coupon();						//实例化优惠券表的模型
		$couponInfo = $coupon -> getCoupon($userID);//查询订单里的菜品信息
		
		$subtract = new Subtract();					//实例化满减表的模型
		$subtractInfo = $subtract -> getSubtract();//查询满减信息
		
		$menu = new Getmenu();					//实例化菜单表的模型
		$menuInfo = $menu -> getInfo($menuId);//查询订单里的菜品信息
		
		$shop = new Shop();						
		$shopInfo = $shop -> selectShop($_COOKIE['shop_idinfo']);//查询门店的信息		

		$user = new User();
		$vipinfo = $user -> getvipinfo($userID);
		
		//$add = new Add();						
		//$addInfo = $add -> selectadd();			
		
		$table = new Addtable();
		if($_POST)
		{		
			//通过之后进行添加
			$order = new Order();
			$re = $order->add(Yii::$app->request->post());
			if($re){
				$request = Yii::$app->request->post();
				
				$arr["id"] = base64_encode(substr($re,11)); 	//当天第几个订单
				$arr["order"] = base64_encode($re);			//订单号（全）
				$arr["money"]= base64_encode($request['realPrice']*100);//总价单位为分
				$allinfo = implode(",",$arr);
				if($_POST['payonoff'] == "online"){
					$orderprice = $request['realPrice'];	//订单价格
					setcookie('allprice',$orderprice);						
					header("location:/web/index.php?r=weixinpay/index&order_info=$allinfo");//跳转到使用微信支付支付
				} else if($_POST['payonoff'] == "balance"){
						$orderprice = $request['realPrice'];	//订单价格	
						setcookie('allprice',$orderprice);						
						$user = new User();					//实例化user表			
						$user_price = $order -> getpocket($userID);
						$price = $user_price['user_price'];	//用户的余额
						$orderprice=sprintf("%.2f", $orderprice);
						//echo $price."aaa".$orderprice;die;
							if($price < $orderprice){
								echo "<script>alert('余额不足')</script>";
								echo "<script>history.go(-1)</script>";die;
							}
						$upd_price = $user -> updprice($userID,$orderprice);//修改user表中的信息
						if($upd_price){
							header("location:/web/index.php?r=paylist/paysuccess&allprice=$orderprice");//本控制器下的支付成功的方法
					}else{
						echo mysql_error;die;
					}
				}
			}else{
				echo "You Had show Too many errors on this page!";
			}
		}

       return  $this->render('pay-list-2',[
		  'model'  	=>$table,	           //传--表单model
		   'menu'   =>$menuInfo,	      //传--选中菜单的信息
		 'wallet' 	=>$walletInfo,       //传--用户是否有红包
		 'coupon'	=>$couponInfo,		//传--用户拥有的优惠券
	   'subtract'   =>$subtractInfo,   //传--满减信息
		'shop' 		=>$shopInfo,   	 //传--门店信息
		'add'		=>$addInfo,		//传--满赠信息	
		'vipinfo'	=>$vipinfo	   //传--折扣信息
		]);

    }
    
    /*
     * 支付流程3     自提
     * */
    public function actionPaylist3(){
		$string = $_GET['r'];
		$action = substr($string,8);
		setcookie("action_name",$action);
		
		$openid = $_COOKIE['openid'];
		$order = new Order();
		$user = $order->getuserid($openid);
		if($user){
			$user_id = $user['user_id'];
			setcookie("user_id",$user_id);
		}else{
			echo "get the error information！";die;
		}	
	
		$session = Yii::$app->session;
		$userID = $user_id;		//现在登录用户的ID
		$menuId = array();
		$menuId = json_decode($session['user_order'],1); //获取选中的菜品数量及其id
		
		
		$wallet = New Wallet();						//实例化红包表的模型
		$walletInfo = $wallet->getWallet($userID);//查询登录用户的红包 有返回‘1’，没有返回‘0’
		
		$coupon = New Coupon();						//实例化优惠券表的模型
		$couponInfo = $coupon -> getCoupon($userID);//查询订单里的菜品信息
		
		$subtract = new Subtract();					//实例化满减表的模型
		$subtractInfo = $subtract -> getSubtract();//查询满减信息
		
		$menu = new Getmenu();					//实例化菜单表的模型
		$menuInfo = $menu -> getInfo($menuId);//查询订单里的菜品信息
		
		$shop = new Shop();						
		$shopInfo = $shop -> selectShop($_COOKIE['shop_idinfo']);//查询门店的信息	

		$user = new User();
		$vipinfo = $user -> getvipinfo($userID);
		
		//$add = new Add();						
		//$addInfo = $add -> selectadd();			
		
		$table = new Addtable();
		if($_POST)
		{
			//通过之后进行添加
			$order = new Order();
			$re = $order->addself(Yii::$app->request->post());
			if($re){
				$request = Yii::$app->request->post();
				
				$arr["id"] = base64_encode(substr($re,11)); 	//当天第几个订单
				$arr["order"] = base64_encode($re);			//订单号（全）
				$arr["money"]= base64_encode($request['realPrice']*100);//总价单位为分
				$allinfo = implode(",",$arr);
				if($_POST['payonoff'] == "online"){
					$orderprice = $request['realPrice'];	//订单价格
					setcookie('allprice',$orderprice);					
					header("location:/web/index.php?r=weixinpay/index&order_info=$allinfo");//跳转到使用微信支付支付
				} else if($_POST['payonoff'] == "balance"){
						$orderprice = $request['realPrice'];	//订单价格
						setcookie('allprice',$orderprice);
						$user = new User();					//实例化user表			
						$user_price = $order -> getpocket($userID);
						$price = $user_price['user_price'];	//用户的余额
						$orderprice=sprintf("%.2f", $orderprice);
						//echo $price."aaa".$orderprice;die;
							if($price < $orderprice){
								echo "<script>alert('余额不足')</script>";
								echo "<script>history.go(-1)</script>";die;
							}
						$upd_price = $user -> updprice($userID,$orderprice);//修改user表中的信息
						if($upd_price){
							header("location:/web/index.php?r=paylist/paysuccess&allprice=$orderprice");//本控制器下的支付成功的方法
					}else{
						echo mysql_error;die;
					}
				}
			}else{
				echo "000";
			}
		}

        return $this->render('pay-list-3',[
		  'model'  	=>$table,	           //传--表单model
		   'menu'   =>$menuInfo,	      //传--选中菜单的信息
		 'wallet' 	=>$walletInfo,       //传--用户是否有红包
		 'coupon'	=>$couponInfo,		//传--用户拥有的优惠券
	   'subtract'   =>$subtractInfo,   //传--满减信息
		'shop' 		=>$shopInfo,   	 //传--门店信息
		'add'		=>$addInfo,		//传--满赠信息
		'vipinfo'	=>$vipinfo	   //传--折扣信息
		]);
		
    }
	
	///进入订单界面
	public function actionIndex()
    {
        if (empty($_GET['menu'])) {
            $shop_id = $_COOKIE["shop_idinfo"];
            $menu = $_COOKIE["menuinfo"];
        } else {
			$shop_id = Yii::$app->request->get('shop_id');
			$menu = trim(Yii::$app->request->get('menu'));
		}
        setcookie("menuinfo","$menu");

		$www = $_SERVER['HTTP_HOST'];
        setcookie("shop_idinfo",$shop_id,time()+360000000,"/","$www",0);
        setcookie("menuinfo","$menu",time()+360000000,"/","$www",0);

		setcookie("m_s","menu=".$menu."&shop_id=".$shop_id);
		
	    $order = new Order();
		$getcart = $order->getArrinfo($menu);
		$cart = new Cart();
		$cart_status = $cart->insertAll($getcart);

		if(!$cart_status){die('购物车添加失败');}
		
		$getarr = $order->getArrinfo($menu);

		$session = Yii::$app->session;
		$session['user_order'] = json_encode($getarr);
		return $this->render('index');
	}
	
	//获取当前用户的账户余额
	public function actionGetpocket()
	{
		$order = new Order();
		$uid = $_COOKIE['user_id'];
		$user_price = $order -> getpocket($uid);
		$price = $user_price['user_price'];//账户余额
		$all = Yii::$app->request->get('all');  //菜单总价
		if($all > $price){
			return 0;
		}else{
			return 1;
		}
	}
	
	//支付成功跳转的页面
	public function actionPaysuccess()
	{
		if(isset($_COOKIE['coupon_id'])){
			$coupon = $_COOKIE['coupon_id'];
		}else{
			$coupon = '';
		}
		if(isset($_COOKIE['wallet_id'])){
			$wallet = $_COOKIE['wallet_id'];
		}else{
			$wallet = '';
		}		
		
		$user_id = $_COOKIE['user_id'];	
		$order_sn =  $_COOKIE['sn_'.$user_id];	//获取当前的订单号码
		$order_num =  $_COOKIE['num_'.$user_id];	//获取当前的订单号码
		//获取本次实际消费金额 
		if(isset($_GET['allprice'])){
			$allprice = $_GET['allprice'];		
		}else{
			$allprice = $_COOKIE['allprice'];		
		}		

		$cart = new Cart();
		$delre = $cart -> clearByUid($user_id);
			
		$user = new user();
		$updatevir = $user -> updatevir($user_id,$allprice,$coupon,$wallet);//根据消费的金额修改用户的积分、优惠券、红包
		
		$order = new Order();
		$updstatus = $order -> updatestatus($order_sn);	//根据订单号码修改订单的状态 从0（为支付）改为支付（1）以及支付时间
		
		//$shopmenu = new ShopMenu();
		//$shop_id = $_COOKIE['shop_idinfo'];
		//$updnum = $shopmenu -> updnum($shop_id,$order_sn);
		
		if($updatevir and $updstatus){
				$appid = "wxa30af7dbdde547b8";
				$secret = "532f76adb7e282990a4db46560fd5683";

				$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". $appid."&secret=".$secret ;
				$res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
				//echo $res;
				$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
				$access_token = $result['access_token'];
				$openid =$_COOKIE["openid"];
				$time = date("Y-m-d h:i:s",time());
				$content = "订单支付状态\n".$time."\n你好你已经成功下单取单号是".$order_num."\n订单号是".$order_sn."\n订单状态：成功\n时间：".$time."\n感谢你对宅食送的支持！";

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
			echo '<script>alert("支付成功")</script>;';
			setcookie('coupon_id','',time() - 3600);
			setcookie("c_price", "", time() - 3600);
			setcookie("wallet_id", "", time() - 3600);
			echo "<script>location.href=\"/web/index.php?r=order/index&userid=$user_id\"</script>";//跳转到用户中心
		}else{
			
		}
	}
	
	
	//支付失败跳转的界面
	public function actionPayerror()
	{
        $user_id = $_COOKIE['user_id'];
		$order_sn =  $_COOKIE['sn_'.$user_id];		//获取当前的订单号码
		$order_num =  $_COOKIE['num_'.$user_id];	//获取当前的取餐号码
		//将订单的优惠券改为优惠券的id
		if(isset($_COOKIE['coupon_id'])){
			$order = new Order();
			$order->chagecoupon($order_sn,$_COOKIE['coupon_id']);
		}
		
		$appid = "wxa30af7dbdde547b8";
		$secret = "532f76adb7e282990a4db46560fd5683";

		$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". $appid."&secret=".$secret ;
		$res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
		//echo $res;
		$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
		$access_token = $result['access_token'];
		$openid =$_COOKIE["openid"];
		$time = date("Y-m-d h:i:s",time());
		$content = "订单支付状态\n".$time."\n你好,下订单失败订单号是".$order_sn."\n订单状态：失败\n时间：".$time."\n,请重新选购或支付订单。\n感谢你对宅食送的支持！";

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
		setcookie("c_price", "", time() - 3600);	
        header("location:/web/index.php?r=order/index&userid=".$user_id);//跳转到用户中心
	}
	
	//跳转到选择红包的界面
	public function actionChoicewallet()
	{
		$userID = $_COOKIE['user_id'];
		$wallet = New Wallet();						//实例化红包表的模型
		$walletInfo = $wallet->getWalletinfo($userID);//查询登录用户的红包
		return $this->render('choicewallet',['wallet'=>$walletInfo]);
	}
	
	//选择红包之后的跳回去
	public function actionGetware()
	{ 
		$m_s = $_COOKIE['m_s'];
		setcookie("wallet_id",$_GET['wallet_type']);
		$index = $_COOKIE['action_name'];

		header("location:index.php?r=paylist/".$index."&".$m_s);	//跳转到原订单界面
	}
	
	
	//跳转到选择优惠券的界面
	public function actionChoicecoupon()
	{
		$userID = $_COOKIE['user_id'];
		$coupon = New Coupon();							//实例化优惠券表的模型
		$couponInfo = $coupon->getCouponinfo($userID);//查询登录用户的优惠券
		
		return $this->render('choicecoupon',['coupon'=>$couponInfo]);
			
	}
	
	//选择优惠券之后跳回去
	public function actionGetcore(){

		setcookie("c_price",$_GET['coupon_type']);
		setcookie("coupon_id",$_GET['coupon_id']);
		$m_s = $_COOKIE['m_s'];
		$index = $_COOKIE['action_name'];
		header("location:index.php?r=paylist/".$index."&".$m_s);//跳转到原订单界面
	}
	
	//选择地址
	public function actionChoiceaddress(){
		$userID = $_COOKIE['user_id'];
		$order = new Order();
		$useraddress = $order -> getAddresslist($userID);
		
		return $this->render('choiceaddress',['address'=>$useraddress]);
	}
	
	//点击地址信息调回订单界面
	public function actionGetaddress(){
		$address_id = $_GET['address_type'];
		$address_name = $_GET['address_name'];
		$user_name = $_GET['user_name'];
		$user_sex = $_GET['user_sex'];
		$user_phone = $_GET['user_phone'];
		
		setcookie('uname',$user_name);
		setcookie('usex',$user_sex);
		setcookie('uphone',$$user_phone);
		setcookie("address_id",$address_id);
		setcookie("address_name",$address_name);
		$m_s = $_COOKIE['m_s'];
		$index = $_COOKIE['action_name'];
		header("location:index.php?r=paylist/".$index."&".$m_s);	//跳转到原订单界面
	}
	
	
	
	
	//根据支付状态  推送对应的消息
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
	
	
	//在我的订单页面  点击分享红包的时候  如果分享成功  就去更改
	
	public function actionChangeshare()
	{
		$order_sn = $_GET['order_sn'];
		$order = new Order();
		$res = $order -> changeshare($order_sn);
		if($res){
			return 1;
		}else{
			return 0;
		}
		
	}
	
	
	//在订单界面点击买单
	public function actionAccounts(){
		$order_sn = $_GET['order_sn'];
	
		$order = new Order();
		$order_info = $order -> get_order($order_sn);
		$user_id = $order_info['user_id'];
		$allPrice = $order_info['order_total'];
		$payonoff = $order_info['payonoff'];
		$meal_number = $order_info['meal_number'];
		setcookie("sn_".$user_id,$order_sn);
		setcookie("num_".$user_id,$meal_number);
		if(isset($_COOKIE['user_id'])){
			
		}else{
			setcookie("user_id",$user_id);
		}
		if($order_info['coupon']){
			$coupon = floor($order_info['coupon']);
		}else{
			$coupon = '';
		}
		setcookie("coupon_id",$coupon);

		$arr["id"] = base64_encode(substr($order_sn,11)); 	//当天第几个订单
		$arr["order"] = base64_encode($order_sn);			//订单号（全）
		$arr["money"]= base64_encode($allPrice*100);//总价单位为分
		$allinfo = implode(",",$arr);		
		
		
		if($payonoff == "online"){
			setcookie('allprice',$allPrice);					
			header("location:/web/index.php?r=weixinpay/index&order_info=$allinfo");//跳转到使用微信支付支付
		}  else if($payonoff == "balance"){
						setcookie('allprice',$allPrice);
						$user = new User();					//实例化user表			
						$user_price = $order -> getpocket($user_id);
						$price = $user_price['user_price'];	//用户的余额
						$orderprice=sprintf("%.2f", $allPrice);
						//echo $price."aaa".$orderprice;die;
							if($price < $orderprice){
								echo "<script>alert('余额不足')</script>";
								echo "<script>history.go(-1)</script>";die;
							}
						$upd_price = $user -> updprice($user_id,$orderprice);//修改user表中的信息
						if($upd_price){
							header("location:/web/index.php?r=paylist/paysuccess&allprice=$orderprice");//本控制器下的支付成功的方法
					}else{
						echo mysql_error;die;
					}
				}
		
	}
	
	public function actionTest(){
		$order = new Order();
		$useraddress = $order -> getAddresslist(8);//查询用户添加过的送餐地址信息
		print_r($useraddress);
	}
}
?>