<?php

namespace backend\models\shop;

use Yii;

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
class Admin extends \yii\db\ActiveRecord
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
	* @Action	查询我的门店信息
	* @param		$id	管理员的id
	*/
	function myshop($id)
	{
		$list = $this->find()
				->select('*')
				->innerJoin("`zss_admin_shop` on `zss_admin`.`id`=`zss_admin_shop`.`admin_id`")
				->innerJoin("`zss_shop` on `zss_admin_shop`.`shop_id` = `zss_shop`.`shop_id`")
				->where(["zss_admin.id"=>$id])
				->asArray()
				->one();
		$type= (new \yii\db\Query())->from('zss_shop_type')->where(['shop_id' => $list['shop_id']])->all();
		$shop_type = array();
		foreach($type as $v)
		{
			$shop_type[] = $v['type_id'];
		}
		 return array_merge($list, array('shop_type' => $shop_type));
	}
	
	/**
	* @Action	取得门店数量
	* @param		$id	店长的id
	*/
	function shopnum($id)
	{
		return $num =(new \yii\db\Query())
							->from('zss_admin_shop')
							->where(['zss_admin_shop.admin_id' => $id])
							->count();
	}

	//门店列表
	function shop_list($id)
	{
		return $rows = (new \yii\db\Query())    
			->select("*")    
			->from('zss_admin_shop')
			->leftJoin('zss_shop', 'zss_shop.shop_id = zss_admin_shop.shop_id')
			->where(['zss_admin_shop.admin_id' => $id])    
			->all();
	}

	function username($id)
	{
		return $admin =(new \yii\db\Query())
							->select(["id","username"])
							->from('zss_admin')
							->where(['zss_admin.id' => $id])
							->one();
	}
}
