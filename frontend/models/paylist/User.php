<?php

namespace app\models\paylist;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_phone
 * @property string $user_password
 * @property string $user_price
 * @property integer $user_virtual
 * @property string $user_sex
 * @property integer $vip_id
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $updated_id
 * @property integer $updated_at
 * @property integer $user_lastlogin
 * @property integer $user_status
 * @property string $user_lastip
 * @property string $wallet_id
 * @property string $coupon_id
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_price'], 'number'],
            [['user_virtual', 'vip_id', 'company_id', 'created_at', 'updated_id', 'updated_at', 'user_lastlogin', 'user_status'], 'integer'],
            [['user_name'], 'string', 'max' => 30],
            [['user_phone'], 'string', 'max' => 11],
            [['user_password'], 'string', 'max' => 32],
            [['user_sex'], 'string', 'max' => 2],
            [['user_lastip'], 'string', 'max' => 15],
            [['wallet_id', 'coupon_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'user_password' => 'User Password',
            'user_price' => 'User Price',
            'user_virtual' => 'User Virtual',
            'user_sex' => 'User Sex',
            'vip_id' => 'Vip ID',
            'company_id' => 'Company ID',
            'created_at' => 'Created At',
            'updated_id' => 'Updated ID',
            'updated_at' => 'Updated At',
            'user_lastlogin' => 'User Lastlogin',
            'user_status' => 'User Status',
            'user_lastip' => 'User Lastip',
            'wallet_id' => 'Wallet ID',
            'coupon_id' => 'Coupon ID',
        ];
    }
	
	
	//使用余额支付的时候减去对应用户的账户余额
	public function updprice($uid,$price){
		$info = $this->findOne($uid);
		$info->user_price = $info->user_price-$price;
		return $info->save();
		
	}
	
	//支付成功后加上对应的积分
	public function updatevir($uid,$allprice,$coupon,$wallet){
		$info = $this->findOne($uid);
		//修改优惠券
		$cou = $info->coupon_id;
		$re_cou1 = str_replace($coupon,'',$cou);
		$last_cou = trim(str_replace(',,',',',$re_cou1),',');
		//修改红包
		$wal = $info->wallet_id;
		$re_wal1 = str_replace($wallet,'',$wal);
		$last_wal = trim(str_replace(',,',',',$re_wal1),',');		
		
		$info->coupon_id = $last_cou;
		$info->wallet_id = $last_wal;
		$info->user_experience = $info->user_experience+floor($allprice);	//添加本次订单生成的经验值
		$info->user_virtual = $info->user_virtual+floor($allprice);
		return $info->save(); 
	}
	
	public function getvipinfo($userid){
		$return = array();
		$info = $this->find()
			 ->select(["zss_company.company_discount",
					"zss_company.company_name",
					"zss_vip.vip_name",
					"zss_vip.vip_discount"])
			 ->leftjoin("`zss_vip` on `zss_user`.`vip_id` = `zss_vip`.`vip_id`")
			 ->leftjoin("`zss_company` on `zss_user`.`company_id` = `zss_company`.`company_id`")
			 ->where("zss_user.user_id = ".$userid)
			 ->asArray()
			 ->one();
			 
		if(empty($info['company_name']) and empty($info['vip_name'])){
			$return['name'] = '无';
			$return['discount'] = 100;
			return $return;
		}else if(empty($info['company_name'])){
			$return['name'] = $info['vip_name'];
			$return['discount'] = $info['vip_discount'];
			return $return;
		}else if(empty($info['vip_name'])){
			$return['name'] = $info['company_name'];
			$return['discount'] = $info['company_discount'];
			return $return;
		}else{
			if($info['vip_discount'] > $info['company_discount']){
				$return['name'] = $info['vip_name'];
				$return['discount'] = $info['vip_discount'];
				return $return;				
			}else{
				$return['name'] = $info['company_name'];
				$return['discount'] = $info['company_discount'];
				return $return;				
			}
		}
	}
}
