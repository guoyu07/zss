<?php

namespace frontend\models\Order;

use Yii;

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
            [['order_sn', 'user_id', 'shop_id', 'delivery_type', 'seat_number', 'meal_number', 'gift_id', 'pay_type', 'pay_status', 'pay_at', 'created_at', 'updated_at', 'order_status', 'discount_type', 'discount'], 'integer'],
            [['order_freight', 'order_payment', 'order_total'], 'number'],
            [['order_address', 'user_name'], 'string', 'max' => 30],
            [['user_phone'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单ID',
            'order_sn' => '订单号码',
            'user_id' => '用户ID',
            'shop_id' => '门店id',
            'order_freight' => '运费',
            'delivery_type' => '派送类型',
            'order_address' => '收货人地址',
            'seat_number' => '座位号',
            'meal_number' => '取餐号',
            'user_name' => '用户姓名',
            'user_phone' => '手机号码',
            'order_payment' => '订单实付款',
            'order_total' => '总价格',
            'gift_id' => '赠品id',
            'pay_type' => '支付方式',
            'pay_status' => '支付状态',
            'pay_at' => '支付时间',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'order_status' => '订单状态',
            'discount_type' => 'Discount Type',
            'discount' => 'Discount',
        ];
    }

	/**
     * @inheritdoc	查询用户的订单
	 * @param $user_id 用户的id
	 * @param $delivery_type PS :  1送货，2自取，3堂食
     */
	 public function userOrder($where)
	 {
		 //获取订单列表
		 $list = $this->find() 
				->select(["zss_order.order_id","type_name","order_payment","zss_shop.shop_name","order_sn","zss_order.created_at","zss_order.meal_number","zss_order.seat_number","order_status","zss_order.share_wallet","delivery_type","order_success","confirm_time","zss_order_admin.order_id as deli"])
				->leftJoin("zss_user","zss_order.user_id = zss_user.user_id")
				->leftJoin("zss_type","zss_order.delivery_type = zss_type.type_id")
				->leftJoin("zss_shop","zss_shop.shop_id = zss_order.shop_id")
				->leftJoin("zss_order_admin","zss_order_admin.order_id = zss_order.order_id")
				->orderBy(['zss_order.order_id'=>SORT_DESC])
				->where($where)
				->asArray()
				->all();
		 //获取订单的make
		 foreach($list as $key=>$val)
		 {
			 $list[$key]['make'] = $rows = (new \yii\db\Query())->select(['is_make'])->from('zss_order_info')->where(['order_id'=>$val['order_id']])->all();
		 }
		 //定义当前状态 line  
		 //0：未支付	 1：已付款		2：已经接单	3:订单交易完成
		 foreach($list as $key=>$value)
		 {
			 if($value['order_status']==0)
			 {
				 $list[$key]['line'] = "未支付";
			 }
			 if($value['order_status']==1)
			 {
				 $list[$key]['line'] = "已付款";
			 }
			 if($value['order_status']==2)
			 {
				 $num = count($value['make']);
				 $k = 0;
				 foreach($value['make'] as $vv)
				 {
					 if($vv['is_make']==1)
					 {
						 $k++;
					 }
				 }
				 if($k == $num)
				 {
					 $list[$key]['line'] = "制作完成";
				 }
				 else
				 {
					 $list[$key]['line'] = "制作中";
				 }
			 }
			 if($value['order_status']==3)
			 {
				 $list[$key]['line'] = "订单交易完成";
			 }
			 unset($list[$key]['make']);
		 }
		 return $list;		 
	}

    /**
     *@Action 订单详情
	 *@param $id 订单的id
     */
	 public function OrderList($id)
	{
		 return $list = $this->find()
				->select(["shop_name","lunchbox","zss_order.order_id","order_sn","zss_order.seat_number","zss_order.meal_number","site_name as user_name","order_payment","order_total","pay_type","pay_status","wallet","sub","msg","coupon","delivery_type","order_freight","site_phone as user_phone","site_detail as order_address","zss_order.created_at","payonoff","pay_at","confirm_time","order_success"])
				->leftJoin("zss_site","zss_order.order_address = zss_site.site_id")
				->leftJoin("zss_type","zss_order.delivery_type = zss_type.type_id")
				->leftJoin("zss_shop","zss_order.shop_id = zss_shop.shop_id")
				->where(["zss_order.order_id"=>$id])
				->asArray()
				->one();
	}
	
	/**
     * @inheritdoc	取得配送员
     */
	function distribution($order_id)
	{
		return $this->find()
				->select(['username',"phone","add_time"])
				->leftJoin("zss_order_admin","zss_order_admin.order_id = zss_order.order_id")
				->leftJoin("zss_admin","zss_admin.id = zss_order_admin.admin_id")
				->where(["zss_order.order_id"=>$order_id])
				->asArray()
				->one();
		/*
		$result = (new \yii\db\Query())
				->select("distribution_id,add_time")
				->from('zss_order_distribution')
				->where(['order_id' => $order_id])
				->one();
		$data = $this->distributioninfo($result);
		return $arr = array(
			"add_time" => $result['add_time'],
			"distribution_name" => $data['distribution_name'],
			"distribution_tel" => $data['distribution_tel'],
		);
		*/
	}
	function distributioninfo($result)
	{
		return $data = (new \yii\db\Query())
				->select("distribution_name, distribution_tel")
				->from('zss_distribution')
				->where(['distribution_id' => $result['distribution_id']])
				->one();
	}

	 /**
     * @inheritdoc	获取用户id
     */
	 function userID($openid)
	{
		 $user = (new \yii\db\Query())
				->select(['user_id'])
				->from('zss_user')
				->where(['user_virtual' => $openid])
				->one();
		 if($user)
		{
			 return $user['user_id'];
		}
		else
		{
			return false;
		}
	}

	/**
     * @inheritdoc	查询配送类型
     */
	 function type()
	{
		 return $type = (new \yii\db\Query())
				->select(['type_id', 'type_name'])
				->from('zss_type')
				->all();
	 }

    /**
     * @查询当前用户积分
     */
	 public function get_order_virtual($id)
	 {
		 return $this->find()
                 ->select(['shop_name',"FROM_UNIXTIME(pay_at,'%m-%d %H:%i')",'order_payment','order_virtual'])
                 ->innerJoin('zss_shop','zss_order.shop_id=zss_shop.shop_id')
                 ->limit(10)
                 ->where(['user_id'=>$id,'order_status'=>1])->asArray()->all();
	 }








}
