<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use backend\models\user\User;
use backend\models\market\Wallet;
use frontend\models\Weixin;
use backend\models\market\Coupon;
use backend\models\shop\Shop;
/**
 * This is the model class for table "{{%weixin}}".
 *
 * @property integer $wx_id
 * @property integer $user_id
 * @property string $wx_name
 */
class Zssuser extends Model
{

	/*添加用户 详细信息
	 * return 添加后的主键值
	*/
	public function insrtuserinfo($variable){

		$model = new User();

		foreach ($variable as $key => $value) {
			
			$model->$key = $value;
		}
			$model->save();

			return $model->attributes['user_id'];
	}

	/*添加用户 微信信息
	 * return true OR false
	 *$number手机号注册  $weixin微信端信息
	*/
	public function adduser($number,$weixin)
	{

		$model = new Weixin();
		$walletid = Wallet::find()->select(["wallet_id"])->where(["is_share"=>0])->asArray()->one();
		$id = $walletid['wallet_id'];
		$arr=array(
					"user_name"=>"$weixin",
					"user_phone"=>"$number",
					"user_password"=>"123131",
					"user_price"=>"123",
					"user_virtual"=>"25",
					"user_sex"=>"0",
					"vip_id"=>1,
					"company_id"=>1,
					"created_at"=>time(),
					"updated_at"=>time(),
					"user_lastlogin"=>time(),
					"user_status"=>"1",
					"wallet_id"=>"$id ",//注册分享红包id
					'user_lastip' => '127.0.0.1'
					);

		$user_id = $this->insrtuserinfo($arr);

		$model->wx_name = $weixin;

		$model->user_id = $user_id;

		return $model->save();
	    
	}

	public function insertweixin($username){

	$model = new Weixin();

	$model->wx_name = $username;

	$model->user_id = 2;

	return $model->save();
	}		

	/*获取用户所有红包信息
	 * return true OR false
	 *
	*/
	public function mywallet($userid)
	{
		$info = User::find()
			  ->select("wallet_id")
			  ->where(["user_id"=>$userid])
			  ->asArray()
			  ->one();
		$allwallet = explode(",",$info["wallet_id"]);
		
		return Wallet::find()
				->select(["wallet_id","wallet_price","wallet_number","wallet_endtime","wallet_money"])->where(["wallet_id"=>$allwallet])
				->asArray()
				->all();

				  
	}

	/*用户添加红包信息
	 * return true OR false
	 *
	*/
	public function insertwallet($number,$userid)
	{	
		$time = time();
	    $info = Wallet::find()
				->select(["wallet_id","wallet_endtime"])
				->where(['wallet_number'=>$number])
				->asArray()
				->one();

		if ($info) {

			if ($time>$info["wallet_endtime"]) {
				
				return false;
			
			}else{
			
			$allinfo = $this->mywallet($userid);
				if(empty($allinfo)){

					$newwalletid = $info["wallet_id"];

				return  User::updateAll(array("wallet_id"=>$newwalletid),array("user_id"=>$userid));
				
				}else{
				foreach ($allinfo as $key => $value) {
						
						$arr[] = $value["wallet_id"];
				}

				if (!in_array($info["wallet_id"],$arr)) {
						
				$newwalletid = implode(",",$arr).",".$info["wallet_id"];

				return  User::updateAll(array("wallet_id"=>$newwalletid),array("user_id"=>$userid));							
				}
			}
			}	
		}else{
			return false;
		}			
	}

	/*获取用户所有代金券信息
	 * return true OR false
	 *
	*/
	public function mycoupon($userid)
	{
		$info = User::find()
			  ->select("coupon_id")
			  ->where(["user_id"=>$userid])
			  ->asArray()
			  ->one();
		$allwallet = explode(",",$info["coupon_id"]);
		
		return Coupon::find()
				->select(["coupon_id","coupon_price","coupon_number","end_at","coupon_money"])->where(["coupon_id"=>$allwallet])
				->asArray()
				->all();

				  
	}

	/*用户添加代金券信息
	 * return true OR false
	 *
	*/
	public function insertcoupon($number,$userid)
	{	
		$time = time();
	    $info = Coupon::find()
				->select(["coupon_id","end_at"])
				->where(['coupon_number'=>$number])
				->asArray()
				->one();

		if ($info) {

			if ($time>$info["end_at"]) {
				
				return false;
			
			}else{

			$allinfo = $this->mycoupon($userid);
				
			if(empty($allinfo)){
				$newwalletid = $info["coupon_id"];

				return  User::updateAll(array("coupon_id"=>$newwalletid),array("user_id"=>$userid));		
			
			}else{


				foreach ($allinfo as $key => $value) {
						
						$arr[] = $value["coupon_id"];
				}
				if (!in_array($info["coupon_id"],$arr)) {
						
				$newwalletid = implode(",",$arr).",".$info["coupon_id"];

				return  User::updateAll(array("coupon_id"=>$newwalletid),array("user_id"=>$userid));							
				}
			}
			}	
		}else{
			return false;
		}			
	}

	/*获取所有门店信息 xml 返回
	 * return true OR false
	 *
	*/
	public function allshop()
	{	
			$model = new Shop();

			$allinfo = $model->shop_list();

			$info = "";

			foreach ($allinfo as $key => $value) {
				
				$info .= $value["shop_name"]."\n地址".$value["shop_address"]."电话：".$value["shop_tel"]."\n\n"; 
			}
			return $info;
	}

	/*获取userid
	 * return userid
	 *
	*/
	public function userid($username)
	{	
		$model = new Weixin();

		return 	$model->find()->select(["user_id"])->where(["wx_name"=>$username])->asArray()->one();

	}

	/*获取openid
	 * return openid
	 *
	*/
	public function openid($userid)
	{	
		$model = new Weixin();

		return 	$model->find()->select(["wx_name"])->where(["user_id"=>$userid])->asArray()->one();

	}





}