<?php

namespace backend\models\distribution;

use Yii;
use backend\models\order\Order;
use backend\models\distribution\Orderadmin;
/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $role
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $login_time
 * @property string $login_ip
 */
class Admines extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['role', 'status', 'created_at', 'updated_at', 'login_time'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['login_ip'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'role' => 'Role',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'login_time' => 'Login Time',
            'login_ip' => 'Login Ip',
        ];
    }

	/**
	*@Des 取得相对应的门店的订单
	*@return array
	*/
	public function AdminOrder($userid,$shop_id)
	{
		return $order = (new \yii\db\Query())
			->select(['order_id', 'order_sn','site_name','meal_number','site_phone','site_detail'])    
			->from('zss_order')
			->leftJoin("zss_site","zss_site.site_id = zss_order.order_address")
			->where(['shop_id' => $shop_id, "status"=>0, "delivery_type"=>3])
			->all();
	}

	/**
	*@Des 取得用户对应的店铺
	*@return 店铺信息 id
	*/
	function AdminShop($userid)
	{
		return $this->find()
				->select(['zss_shop.shop_id',"shop_name","username as admin_name"])
				->innerJoin("zss_admin_distribution","zss_admin_distribution.admin_id = zss_admin.id")
				->innerJoin("zss_shop","zss_shop.shop_id = zss_admin_distribution.shop_id")
				->Where(["id"=>$userid])
				->asArray()
				->one();
	}

	/**
	*@Des 抢单
	*@return status
	*/
	function AddOrder($order_id,$userid)
	{
		$result = $this->status($order_id);
		if(!$result)
		{
			return false;die;
		}
		//抢单入库
		$obj = new Orderadmin();
		$obj->order_id =  $order_id;
		$obj->admin_id =  $userid;
		$obj->add_time =  time();
		return $result = $obj->save();
	}
	//修改订单状态
	function status($order_id)
	{
		return $result = Order::updateAll([
				'status'=>1,
			],['order_id'=>$order_id]);
	}
	









}
