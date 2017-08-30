<?php

namespace app\models\paylist;

use Yii;
use app\models\paylist\Orderinfo;
use app\models\paylist\User;
/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $order_id
 * @property integer $order_sn
 * @property integer $user_id
 * @property integer $shop_id
 * @property string $order_freight
 * @property integer $delivery_type
 * @property string $order_address
 * @property integer $seat_number
 * @property integer $meal_number
 * @property string $user_name
 * @property string $user_phone
 * @property string $order_payment
 * @property string $order_total
 * @property integer $gift_id
 * @property integer $pay_type
 * @property integer $pay_status
 * @property integer $pay_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $order_status
 * @property integer $discount_type
 * @property integer $discount
 * @property integer $coupon
 * @property integer $wallet
 * @property integer $sub
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'shop_id', 'delivery_type', 'seat_number', 'meal_number', 'gift_id', 'pay_type', 'pay_status', 'pay_at', 'created_at', 'updated_at', 'order_status', 'discount_type'], 'integer'],
            [['order_freight', 'order_payment', 'order_total'], 'number'],
            [['user_name'], 'string', 'max' => 150],
            [['user_phone'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'shop_id' => 'Shop ID',
            'order_freight' => 'Order Freight',
            'delivery_type' => 'Delivery Type',
            'order_address' => 'Order Address',
            'seat_number' => 'Seat Number',
            'meal_number' => 'Meal Number',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'order_payment' => 'Order Payment',
            'order_total' => 'Order Total',
            'gift_id' => 'Gift ID',
            'pay_type' => 'Pay Type',
            'pay_status' => 'Pay Status',
            'pay_at' => 'Pay At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'order_status' => 'Order Status',
            'discount_type' => 'Discount Type',
            'discount' => 'Discount',
            'coupon' => 'Coupon',
            'wallet' => 'Wallet',
            'sub' => 'Sub',
			'MSG' => 'MSG',
        ];
    }
	
	/*
	*	申明订单类型（派送类型）  字段名  delivery_type   （1：表示堂食    2：表示自提     3：表示外卖形式）
	*/
	
	
	
	
	//添加堂食订单的方法
	public function add($data)
	{
		//在订单信息表里添加数据
		$user_id = $_COOKIE['user_id'];
		$sn = $this->getnum();	
		$order_sn = str_replace(substr($sn,0,13),substr($sn,0,12).'1',$sn);
		//将本次的订单号码存入cookie中  cookie 
		setcookie("sn_".$user_id,$order_sn);
		$this->order_sn = $order_sn;						//添加订单号
		$this->meal_number = substr($order_sn,-2);			//添加取餐号
		setcookie("num_".$user_id,substr($order_sn,-2));	//将本次的取餐号码存入cookie中  cookie 
		$this->user_id = $user_id;							//添加用户ID
		$this->shop_id = $_COOKIE['shop_idinfo'];			//添加门店号
		$this->seat_number = $data['Addtable'];				//添加座位号

		$this->pay_type = $data['paytype'];					//添加支付
		$this->payonoff = $data['payonoff'];				//添加支付方式  线上支付  、余额支付
		$this->coupon = (float)$data['coupon'];				//添加优惠券的抵用金额
		$this->wallet = $data['wallet'];					//添加红包的抵用金额
		$this->sub = (float)$data['sub'];					//添加满减减去金额
		$this->msg = $data['MSG'];							//添加订单的备注
		$this->delivery_type = 1;							//添加派送类型（订单类型）
		$this->order_payment = $data['realPrice'];			//添加订单的实际付款金额
		$this->order_virtual = floor($data['realPrice']);	//添加本次订单生成的积分
		$this->order_total = $data['allprice'];				//添加订单的原本应该付款的金额
		$this->created_at = time();							//添加订单的添加时间
		$this->updated_at = time();							//添加订单的修改时间

		$this->save();							//执行添加订单表的数据
		$lastId = $this->db->getLastInsertID();//刚才插入的数据主键ID
		
		//选取需要添加的订单详情的数据信息
		$arrInfo = array();
		$arrInfo['menu_id'] = $data['menu_id'];
		$arrInfo['menu_num'] = $data['menu_num'];
		$arrInfo['menu_price'] = $data['menu_price'];
		$arrInfo['order_id'] = $lastId;
		//把字符串截取成数组格式
		$id = explode(",",$data['menu_id']);
		$num = explode(",",$data['menu_num']);
		$price = explode(",",$data['menu_price']);		
		$allnum = count($id);				//菜品的种数
		
		$ordertime = time();
		$i = 0;
		foreach($id as $k=>$v){
			$orderinfo = new Orderinfo();	//实例化订单详情
			$orderinfo ->order_id =$arrInfo['order_id'];
			$orderinfo ->menu_id =$id[$k];
			$orderinfo ->menu_num =$num[$k];
			$orderinfo ->menu_price =$price[$k];
			$orderinfo ->created_at =$ordertime;
			if($orderinfo ->save()){
				$i++;
			}
		}
		if($allnum === $i){
			return $order_sn;
		}else{
			return 0;
		}
	}
	
	
	
	//添加自提订单的方法
	public function addself($data)
	{
		//在订单信息表里添加数据
		$user_id = $_COOKIE['user_id'];
		$sn = $this->getnum();			//获取订单号码
		$order_sn = str_replace(substr($sn,0,13),substr($sn,0,12).'2',$sn);
		//将本次的订单号码存入cookie中  cookie 
		setcookie("sn_".$user_id,$order_sn);
		
		$taketime = strtotime($data['add_hour'].':'.$data['add_min']); 
		$this->order_sn = $order_sn;						//添加订单号
		$this->meal_number = substr($order_sn,-2);			//添加取餐号
		$this->user_id = $user_id;							//添加用户ID
		$this->meal_number = substr($order_sn,-2);			//添加取餐号
		setcookie("num_".$user_id,substr($order_sn,-2));	//将本次的取餐号码存入cookie中  cookie 
		$this->shop_id = $_COOKIE['shop_idinfo'];			//添加门店号
		$this->payonoff = $data['payonoff'];				//添加支付方式  线上支付  、余额支付
		$this->pay_type = $data['paytype'];					//添加支付方式
		$this->coupon = (float)$data['coupon'];				//添加优惠券的抵用金额
		$this->wallet = $data['wallet'];					//添加红包的抵用金额
		$this->sub = (float)$data['sub'];					//添加满减减去金额
		$this->msg = $data['MSG'];							//添加订单的备注
		$this->delivery_type = 2;							//添加派送类型（订单类型）
		$this->order_payment = $data['realPrice'];			//添加订单的实际付款金额
		$this->order_virtual = floor($data['realPrice']);	//添加本次订单生成的积分
		$this->order_total = $data['allprice'];				//添加订单的原本应该付款的金额
		$this->taketime = $taketime;						//添加预定取餐时间
		$this->created_at = time();							//添加订单的添加时间
		$this->updated_at = time();							//添加订单的修改时间

		$this->save();							//执行添加订单表的数据
		$lastId = $this->db->getLastInsertID();//刚才插入的数据主键ID
		
		//选取需要添加的订单详情的数据信息
		$arrInfo = array();
		$arrInfo['menu_id'] = $data['menu_id'];
		$arrInfo['menu_num'] = $data['menu_num'];
		$arrInfo['menu_price'] = $data['menu_price'];
		$arrInfo['order_id'] = $lastId;
		//把字符串截取成数组格式
		$id = explode(",",$data['menu_id']);
		$num = explode(",",$data['menu_num']);
		$price = explode(",",$data['menu_price']);		
		$allnum = count($id);				//菜品的种数
		
		$ordertime = time();
		$i = 0;
		foreach($id as $k=>$v){
			$orderinfo = new Orderinfo();	//实例化订单详情
			$orderinfo ->order_id =$arrInfo['order_id'];
			$orderinfo ->menu_id =$id[$k];
			$orderinfo ->menu_num =$num[$k];
			$orderinfo ->menu_price =$price[$k];
			$orderinfo ->created_at =$ordertime;
			if($orderinfo ->save()){
				$i++;
			}
		}
		if($allnum === $i){
			return $order_sn;
		}else{
			return 0;
		}
	}	

	
	//添加外卖的方法
	public function addsail($data)
	{
		//在订单信息表里添加数据
		$user_id = $_COOKIE['user_id'];
		$sn = $this->getnum();
		$order_sn = str_replace(substr($sn,0,13),substr($sn,0,12).'3',$sn);
		//将本次的订单号码存入cookie中  cookie 
		setcookie("sn_".$user_id,$order_sn);
		
		$this->order_sn = $order_sn;						//添加订单号
		$this->meal_number = substr($order_sn,-2);			//添加取餐号
		setcookie("num_".$user_id,substr($order_sn,-2));	//将本次的取餐号码存入cookie中  cookie 
		$this->user_id = $user_id;							//添加用户ID
		$this->shop_id = $_COOKIE['shop_idinfo'];			//添加门店号
		$this->pay_type = $data['paytype'];					//添加支付方式
		

		$this->payonoff = $data['payonoff'];				//添加支付方式  线上支付  、余额支付
		$this->coupon = (float)$data['coupon'];				//添加优惠券的抵用金额
		$this->order_address = $data['address'];			//添加送餐地址
		$this->wallet = $data['wallet'];					//添加红包的抵用金额
		$this->sub = (float)$data['sub'];					//添加满减减去金额
		$this->msg = $data['msg'];							//添加订单的备注
		$this->delivery_type = 3;							//添加派送类型（订单类型）
		$this->order_payment = $data['realPrice'];			//添加订单的实际付款金额
		$this->order_virtual = floor($data['realPrice']);	//添加本次订单生成的积分
		$this->order_total = $data['allprice'];				//添加订单的原本应该付款的金额
		//当菜品总价大于28的时候我们会免去配送费，否则（菜品总价小于28）加上5元配送费  字段为order_freight
		if( $data['allprice'] > 28){
			
		}else{
			$this->order_freight = 5;				
		}
	
		$this->created_at = time();						//添加订单的添加时间
		$this->updated_at = time();						//添加订单的修改时间

		$this->save();			//执行添加订单表的数据
		$lastId = $this->db->getLastInsertID();//刚才插入的数据主键ID
		
		//选取需要添加的订单详情的数据信息
		$arrInfo = array();
		$arrInfo['menu_id'] = $data['menu_id'];
		$arrInfo['menu_num'] = $data['menu_num'];
		$arrInfo['menu_price'] = $data['menu_price'];
		$arrInfo['order_id'] = $lastId;
		//把字符串截取成数组格式
		$id = explode(",",$data['menu_id']);
		$num = explode(",",$data['menu_num']);
		$price = explode(",",$data['menu_price']);		
		$allnum = count($id);				//菜品的种数
		
		$ordertime = time();
		$i = 0;
		foreach($id as $k=>$v){
			$orderinfo = new Orderinfo();	//实例化订单详情
			$orderinfo ->order_id =$arrInfo['order_id'];
			$orderinfo ->menu_id =$id[$k];
			$orderinfo ->menu_num =$num[$k];
			$orderinfo ->menu_price =$price[$k];
			$orderinfo ->created_at =$ordertime;
			if($orderinfo ->save()){
				$i++;
			}
		}
		if($allnum === $i){
			return $order_sn;
		}else{
			return 0;
		}
	}		
	
	
	
	
	//生成当天的订单号序列
	public function getnum()
	{
		/**
		*	订单号格式为“年份”+”当前月份“+“门店ID”+“订单类型”+”0开头的四位自增数字“
		*/
		//当天的时间戳
		$nowday = strtotime(date("Y-m-d"));
		//获取当天的订单总数
		 $rows = (new \yii\db\Query())
			->select('order_id')
			->from('zss_order')
			->where("created_at > ".$nowday)
			->all();
		$allnum =  count($rows);//数量 
		if($_SESSION['shop_id'] > 9){	
			return $order_sn =  date("YmdH",time()).$_SESSION['shop_id'].str_pad($allnum+1,5,0,STR_PAD_LEFT);
		}else{
			return $order_sn =  date("YmdH",time()).'0'.$_SESSION['shop_id'].str_pad($allnum+1,5,0,STR_PAD_LEFT);
		}
	}
	
	//把传过来的字符数据转成数组
	public function getArrinfo($str)
	{
		$arr1 = explode(" ",trim($str));
		$secarr = array();
		$lastarr = array();
		$last = array();
		$uid = $_COOKIE['user_id']?$_COOKIE['user_id']:0;
		
		foreach($arr1 as $k=>$v){
			$secarr[] = explode(",",$v);
		} 
       foreach($secarr as $k=>$v){
           $lastarr[$k][] = explode("=",$v[0]);
           $lastarr[$k][] = explode("=",$v[1]);
           $lastarr[$k][] = explode("=",$v[3]);
       }
		foreach($lastarr as $k=>$v){
			foreach($v as $kk=>$vv)
			{
				$last[$k]["$vv[0]"] = $vv[1];
			}
			
			$shopid = isset($_COOKIE['shop_idinfo'])?$_COOKIE['shop_idinfo']:0;
			//echo $uid.'=========='.$shopid;die;
			if($uid && $shopid){
			    $last[$k]['user_id'] = $uid;
			    $last[$k]['shop_id'] = $shopid;
			}else{
			    die('必要数据丢失');
			}
		}
		return $last;
	}
	
	//获取登录用户的user_id
	function getuserid($openid)
	{
		$return = (new \yii\db\Query()) 
		->select(['user_id'])   
		->from('zss_weixin')
		->where(['wx_name' => ''.$openid.'']) 
		->limit(1) 
		->One();

		if($return){
			return $return;			
		}else{
			return 0;
		}
	}
	
	
	//获取当前用户的默认送货地址信息
	public function getAddress($userid)
	{
		$return = (new \yii\db\Query()) 
			->select(['site_detail','site_id','site_phone','site_name','site_status','site_sex'])   
			->from('zss_site')
			->where(['user_id' => $userid,'site_status' => 1])
			->limit(1)
			->one();
			if($return){
				return $return;
			}else{
				return 0;
			}
		
	}
	
	//获取当前用户的送货地址列表
	public function getAddresslist($userid){
		return $return = (new \yii\db\Query()) 
			->select(['site_detail','site_id','site_phone','site_name','site_sex'])   
			->from('zss_site')
			->where(['user_id' => $userid])
			->all();		
	}
	
	//获取当前用户的剩余积分
	public function getpocket($userid){
		$return = (new \yii\db\Query()) 
					->select(['user_price'])   
					->from('zss_user')
					->where(['user_id' => $userid]) 
					->one();
		return $return;
	}
	
	
	//修改订单的状态
	public function updatestatus($order_sn)
	{
		$info = $this->find()
				->where("order_sn='$order_sn'")
				->one();
		$info->order_status = 1;
		$info->pay_at = time();
		return $info->save();
	}
	
	
	
	
	
	//修改分享红包后的 share_wallet 的值
	public function changeshare($order_sn){
		$info = $this->find()
				->where("order_sn='$order_sn'")
				->one();		
		$info->share_wallet = 1;
		return $info->save();
	}
	
	
	//根据订单号获取信息
	public function get_order($order_sn){
		return  $this->find()
					->select(['order_total',
							  'coupon',
							  'payonoff',
							  'user_id',
							  'meal_number'
						])
					->from('zss_order')
					->where(['order_sn' => "$order_sn"]) 
					->asarray()
					->one();						
	}
	
	//支付失败将优惠 的金额改为id
	public function chagecoupon($order_sn,$couponid){
		$info = $this->find()
				->where("order_sn='$order_sn'")
				->one();	
			$info->coupon = $couponid;
			return $info->save();
	}

}





