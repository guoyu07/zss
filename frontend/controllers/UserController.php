<?php
namespace frontend\controllers;

use Yii;

use frontend\controllers\BaseController;
use backend\models\user\User;
use backend\models\user\Vip;
use backend\models\user\VipInfo;
use backend\models\user\VipCharge;
use frontend\models\AddressForm;
use frontend\models\Zssuser;
use frontend\models\user\ChargeForm;
use frontend\models\user\Site;
use frontend\models\user\Rebate;
use frontend\models\Order\Order;

/*
 * 用户模块
 * */
class UserController extends BaseController {

    /*
     * 用户中心
     * */
    public function actionIndex(){

        $appid = "wxa30af7dbdde547b8";
        $secret = "532f76adb7e282990a4db46560fd5683";

    if (!isset($_COOKIE["openid"])) {
        @$code = $_GET["code"];

        @$openid = $this->getopenid($appid,$secret,$code);

		$openidt = $openid;
         setcookie("openid",$openidt);


     }else{

		 @$openidt = $_COOKIE["openid"];
          setcookie("openid",$openidt);

	 }

          $www = $_SERVER['HTTP_HOST'];
        setcookie("useropenid","$openidt",time()+3600*7*7,"/","$www",0);

        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". $appid."&secret=".$secret ;
        $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
        //echo $res;
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $access_token = $result['access_token'];

        setcookie("access_token",$access_token);

        $wxuserinfourl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openidt."&lang=zh_CN";
        $wxallinf = file_get_contents($wxuserinfourl);
        $wxallinf = json_decode($wxallinf,true);
        @$img = $wxallinf["headimgurl"];
        setcookie("userphoto",$img);
        $models =  new Zssuser();
        $userid = $models->userid($openidt);

        //设置cookie
        //判断是否有此用户,没登录直接跳转到注册

        if($userid["user_id"]==""){
             header("Location:index.php?r=user/sign");die;
        }
        setcookie("username",$userid["user_id"]);
        //$user_id = $_COOKIE['userid'];
         //$user = User::find()->where(['user_id' => $userid['user_id']])->asArray()->one();
         $users =new User();
         $user = $users->selectone($userid['user_id']);
        //确定红包和优惠券的数量
        $w_num = empty($user['wallet_id'])? 0 :count(explode(",",$user['wallet_id']));
        $c_num = empty($user['coupon_id'])? 0 :count(explode(",",$user['coupon_id']));
        return $this->render('user',[
            'w_num' => $w_num,
            'c_num' => $c_num,
            'user' => $user,
            'userphoto' => $img,
            'userid' => $userid,
        ]);
    }

    public function actionSign(){
         @$openid = $_COOKIE["openid"];
         $models =  new Zssuser();
        $userid = $models->userid($openid);
         if($userid["user_id"]!=""){
             header("Location:index.php?r=user");die;
        }
        header("Location:index.php?r=signup");die;

    }

    /**
     * 用户详细信息
     */
    public function actionUserinfo(){

        $img = $_COOKIE["userphoto"];
        $id = $_COOKIE['username'];
        $user = new User();
        $experience = $user->get_user_experience($id);
        $vip = new Vip();
        if($experience['user_experience'] >= $experience['vip_experience']){
          $re = $vip->vip_level_up($id,$experience['user_experience']);
          if(!$re){
            echo "<script>alert('数据更新失败');history.go(-1);</script>";
          }else{
            $experience['vip_experience'] = $re['vip_experience'];
            $experience['vip_name'] = $re['vip_name'];
          }
        }
        $vips = $vip->get_vip_level();
        $discount = $vip->get_discount();
        $vipinfo = new VipInfo();
        $vipinfos = $vipinfo->get_info();
        return $this->render('userinfo',[
          "userphoto"=>$img,
          'experience'=>$experience,
          'vips'=>$vips,
          'discount'=>$discount,
          'vipinfos'=>$vipinfos
        ]);
    }

    /*
     * 用户登录
     * */
    public function actionSignup()
    {
        return $this->render('signup');
    }

    /**
     * 个人地址管理
     */
    public function actionAddlist()
    {
        $openid = $_COOKIE['openid'];
        $zssuser =  new Zssuser();
        $userid = $zssuser->userid($openid);
        $site = Site::find()->where(['user_id' => $userid['user_id']])->limit(4)->asArray()->all();

        //$site = Site::find()->asArray()->all();
        return $this->render('addlist',[
            'site' => $site,
        ]);
    }



    /**
     * 设置默认地址
     */
    public function actionAddmo(){
        $openid = $_COOKIE['openid'];
        $zssuser =  new Zssuser();
        $userid = $zssuser->userid($openid);

        $siteid = Yii::$app->request->get('siteid');
        //先把原先默认的地址取消掉
        $site = Site::find()->where(['user_id' => $userid['user_id'],'site_status' => '1'])->one();
        //print_r($site);die;
        if(isset($site)||!empty($site)){
         $site->site_status = 0;
         $site->save();
        }

        $sites = Site::find()->where(['site_id' => $siteid])->one();
        if(isset($sites)||!empty($sites)){
            $sites->site_status = 1;
            if($sites->save()){
                //成功
                header("Location:index.php?r=user/index");die;
            }else{
                //失败
                header("Location:index.php?r=user/index");die;
            }
        }else{
             //失败
                header("Location:index.php?r=user/index");die;
        }

    }

    /*
     * 个人地址添加
     */
    public function actionAddaddress()
    {

        $model = new AddressForm();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            //接收数据
            $site = new Site();
            $site->site_name = $post['AddressForm']['username'];
            $site->site_phone = $post['AddressForm']['phone'];
            $site->site_detail = $post['AddressForm']['address'].",".$post['AddressForm']['localnum'];
            $site->site_sex = Yii::$app->request->post('sex');
            $site->created_at = time();
            //实例化调用方法获取user_id
            $openid = $_COOKIE['openid'];
            $zssuser =  new Zssuser();
            $userid = $zssuser->userid($openid);
            $site->user_id = $userid['user_id'];
            if( $site->save() ){
                //成功
               //$infourl = $_SERVER['HTTP_REFERER'];
		header("Location:index.php?r=user/addlist");die;
               // header("Location:".$infourl);die;

            }else{
                //失败
		header("Location:index.php?r=user/addlist");die;
            }
        }else{
               return $this->render('addaddress', [
                   'model' => $model]);
        }

    }

 public function actionFixaddress()
    {

        $model = new AddressForm();
        $post = Yii::$app->request->post();
        $openid = $_COOKIE['openid'];
        $zssuser =  new Zssuser();
        $userid = $zssuser->userid($openid);
        $allinfo = Site::find()->where(['user_id' => $userid['user_id']])->limit(4)->asArray()->all();
        $postinfo  = yii::$app->request->get();
        $postid = $postinfo["id"];
        setcookie("siteid",$postid);
        foreach($allinfo as $ke=>$val){

            if($val["site_id"]==$postid){

                $newinfo[] = $val;//获取当前修改个人收货地址信息
            }
        }

        if ($model->load($post)) {

            //接收数据
            $site = new Site();
            $arrinfo["site_name"] = $post['AddressForm']['username'];
            $arrinfo["site_phone"] = $post['AddressForm']['phone'];
            $arrinfo["site_detail"] = $post['AddressForm']['address'].",".$post['AddressForm']['localnum'];
            $arrinfo["site_sex"] = Yii::$app->request->post('sex');
            $arrinfo["created_at"] = time();
            //实例化调用方法获取user_id
            $siteid = $_COOKIE['siteid'];


            if( $site->updateAll($arrinfo,["site_id"=>$siteid]) ){
                //成功
        header("Location:index.php?r=user/addlist");die;
            }else{
                //失败
        header("Location:index.php?r=user/addlist");die;
            }
        }else{
               return $this->render('fixaddress', [
                   'model' => $model,"info"=>$newinfo]);
        }

    }


    /**
     * 充值页面
     */
    public function actionCharge()
    {
        $openid = $_COOKIE['openid'];
        $zssuser =  new Zssuser();
        $users =new User();
        $charges = new VipCharge();
        $userid = $zssuser->userid($openid);
        $user_id = $userid['user_id'];
        //$udata = User::find()->where(['user_id' => $user_id])->asArray()->one();
        $udata = $users->selectone($user_id);
        //$charge = VipCharge::find()->where(['user_id' => $user_id])->limit(3)->orderBy("created_at DESC")->asArray()->all();
        $charge = $charges->selectlast($user_id);
        $rebate = Rebate::find()->asArray()->all();
        $model = new ChargeForm();
        $post = Yii::$app->request->post();
		setcookie('post',serialize($post));
        if ($model->load($post) && $model->validate()) {
			$chuan = $post['ChargeForm']['money']*100;
		header("location:/web/index.php?r=weixinpay/indext&order_info=$chuan");die;//跳转到使用微信支付支付

         /*   $vipcharge = new VipCharge();
            //$user = new User();
	        $user = User::find()->where(['user_id' => $user_id])->one();
            $user->user_price = $udata['user_price']+$post['ChargeForm']['money'];
            if($user->save()){

                    foreach($rebate as $rk => $rv){
                    $sort[] = $rv['rebate_price'];
                    }
                      rsort($sort);
                      //判断所输入的钱数属于哪个范围内的充值返利
                     if($post['ChargeForm']['money']>=$sort[0]){
                         $lastsend = 500;
                     }elseif($post['ChargeForm']['money']<$sort[0] && $post['ChargeForm']['money']>=$sort[1]){
                         $lastsend = 200;
                     }elseif($post['ChargeForm']['money']<$sort[1] && $post['ChargeForm']['money']>=$sort[2]){
                         $lastsend = 100;
                     }
                     if (isset($lastsend)){
                         $saves = new Rebate();
                         $save = $saves->selectaction($lastsend);
                         //$save = Rebate::find()->select('rebate_price,rebate_send')->where(['rebate_price' => $lastsend])->asArray()->one();
                         $vipcharge->charge_money = $post['ChargeForm']['money'];
                         $vipcharge->charge_send =$save['rebate_send'];
                     }else{
						$vipcharge->charge_money = $post['ChargeForm']['money'];
					 }
                     $vipcharge->user_id = $user_id;
                     $vipcharge->charge_type = 1;
                     $vipcharge->created_at = time();


                     if($vipcharge->save()){
                        //充值成功
                        header("Location:index.php?r=user/index");die;
                     }else{
                        //充值失败
                        header("Location:index.php?r=user/index");die;
                     }
            }else{
                //充值失败
                echo 0;
            }*/
           //print_r($vipcharge);die;
        }else{
            return $this->render('charge',[
                'udata' => $udata,
                'charge' => $charge,
                'rebate' => $rebate,
                'model' =>$model,
            ]);
        }
    }

	/**
	*微信充值
	*/
	public function actionApi()
	{
            $openid = $_COOKIE['openid'];
            $post = unserialize($_COOKIE['post']);
            $zssuser =  new Zssuser();
            $users =new User();
            $charges = new VipCharge();
            $userid = $zssuser->userid($openid);
            $user_id = $userid['user_id'];
            //$udata = User::find()->where(['user_id' => $user_id])->asArray()->one();
            $udata = $users->selectone($user_id);
            //$charge = VipCharge::find()->where(['user_id' => $user_id])->limit(3)->orderBy("created_at DESC")->asArray()->all();
            $charge = $charges->selectlast($user_id);
            $rebate = Rebate::find()->asArray()->all();
            $model = new ChargeForm();
            $vipcharge = new VipCharge();
        //$user = new User();
            $user = User::find()->where(['user_id' => $user_id])->one();
            $user->user_price = $udata['user_price']+$post['ChargeForm']['money'];
            if($user->save()){

                    foreach($rebate as $rk => $rv){
                    $sort[] = $rv['rebate_price'];
                    }
                      rsort($sort);
                      //判断所输入的钱数属于哪个范围内的充值返利
                     if($post['ChargeForm']['money']>=$sort[0]){
                         $lastsend = $sort[0];
                     }elseif($post['ChargeForm']['money']<$sort[0] && $post['ChargeForm']['money']>=$sort[1]){
                         $lastsend = $sort[1];
                     }elseif($post['ChargeForm']['money']<$sort[1] && $post['ChargeForm']['money']>=$sort[2]){
                         $lastsend = $sort[2];
                     }
                     if (isset($lastsend)){
                         $saves = new Rebate();
                         $save = $saves->selectaction($lastsend);
                         //$save = Rebate::find()->select('rebate_price,rebate_send')->where(['rebate_price' => $lastsend])->asArray()->one();
                         $vipcharge->charge_money = $post['ChargeForm']['money'];
                         $vipcharge->charge_send =$save['rebate_send'];
                     }else{
                            $vipcharge->charge_money = $post['ChargeForm']['money'];
			  }
                     $vipcharge->user_id = $user_id;
                     $vipcharge->charge_type = 1;
                     $vipcharge->created_at = time();


                     if($vipcharge->save()){
                        //用户消息推送
                            $appid = "wxa30af7dbdde547b8";
                            $secret = "532f76adb7e282990a4db46560fd5683";

                            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". $appid."&secret=".$secret ;
                            $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
                            //echo $res;
                            $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
                            $access_token = $result['access_token'];
                            $openid =$_COOKIE["openid"];
                            $time = date("Y-m-d h:i:s",time());
                            $content = "订单支付状态\n".$time."\n你好你已经成功下单\n订单状态：充值成功\n时间：".$time."\n感谢你对宅食送的支持！";

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

                        //充值成功
                        header("Location:index.php?r=user/index");die;
                     }else{
                        //充值失败
                        header("Location:index.php?r=user/index");die;
                     }
            }else{
                //充值失败
                header("Location:index.php?r=user/index");die;
            }

	}

	public function actionFalseapi()
	{

         $appid = "wxa30af7dbdde547b8";
        $secret = "532f76adb7e282990a4db46560fd5683";

        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". $appid."&secret=".$secret ;
        $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
        //echo $res;
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $access_token = $result['access_token'];
        $openid =$_COOKIE["openid"];
        $time = date("Y-m-d h:i:s",time());
        $content = "订单支付状态\n".$time."\n你好你已经下单失败\n订单状态：充值失败\n时间：".$time."\n感谢你对宅食送的支持！";

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

        header("Location:index.php?r=user/charge");

        }else{

            header("Location:index.php?r=user/charge");

        }


	}

	/*
     * 用户积分
     * */
    public function actionVirtual(){

        // if ( !isset($_COOKIE['username']) ){
        //   header("Location:index.php?r=signup");die;
        // }
        // $id = $_COOKIE['username'];
        $openid = $_COOKIE['openid'];
        $zssuser =  new Zssuser();
        $userid = $zssuser->userid($openid);
        $id = $userid['user_id'];
        $order = new Order();
        $virtual = $order->get_order_virtual($id);
        $user = new User();
        $virtual_now = $user->get_user_virtual($id);
        return $this->render('virtual',['virtual'=>$virtual,'virtual_now'=>$virtual_now]);
    }






    public function actionShare(){


        $appid = "wxa30af7dbdde547b8";
        $secret = "532f76adb7e282990a4db46560fd5683";

        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=". $appid."&secret=".$secret ;
        $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
        //echo $res;
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $access_token = $result['access_token'];

        //$type = "image";

        //$filepath = dirname(__FILE__)."/hb.jpg";

        // if (class_exists ( '\CURLFile' )) {//关键是判断curlfile,官网推荐php5.5或更高的版本使用curlfile来实例文件
        //     $filedata = array (
        //         'fieldname' => new \CURLFile ( realpath ( $filepath ), 'image/jpeg' )
        //     );
        // } else {
        //     $filedata = array (
        //         'fieldname' => '@' . realpath ( $filepath )
        //     );
        // }
        // $ur = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token ."&type=".$type;
        // $result =$this->upload ( $ur, $filedata );//调用upload函数
        // $infoto = json_decode($result,true);
        // $media_id = $infoto["media_id"];  //获取上传图片ID
        $openid =$_COOKIE["openid"];
        $imgurl = $_SERVER['HTTP_HOST']."/file/hb.jpg";
        $www = $_SERVER['HTTP_HOST']."/web";
        $time = date("Y-m-d h:i:s",time());
        $content = "订单支付状态\n".$time."\n你好你已经下单失败\n订单状态：充值失败\n时间：".$time."\n感谢你对宅食送的支持！";

    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
    $data = "{
    \"touser\":\"$openid\",
    \"msgtype\":\"news\",
    \"news\":{
        \"articles\": [
         {
             \"title\":\"红包分享，送基友大礼！\",
             \"description\":\"快去告诉他/她\",
             \"url\":\"$www\",
             \"picurl\":\"http://www.wujiaweb.com/file/hb.jpg\"
         }
         ]
    }
}";
    $allinfo = $this->https_post($url,$data);

       //header("Location:index.php?r=order");
        echo "<script> alert('分享成功');location.href='index.php?r=order'</script>";//页面跳转
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

 public function upload($url, $filedata) {
        $curl = curl_init ();
        if (class_exists ( '/CURLFile' )) {//php5.5跟php5.6中的CURLOPT_SAFE_UPLOAD的默认值不同
            curl_setopt ( $curl, CURLOPT_SAFE_UPLOAD, true );
        } else {
            if (defined ( 'CURLOPT_SAFE_UPLOAD' )) {
                curl_setopt ( $curl, CURLOPT_SAFE_UPLOAD, false );
            }
        }
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
        if (! empty ( $filedata )) {
            curl_setopt ( $curl, CURLOPT_POST, 1 );
            curl_setopt ( $curl, CURLOPT_POSTFIELDS, $filedata );
        }
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
        $output = curl_exec ( $curl );
        curl_close ( $curl );
        return $output;

    }
 }

?>
