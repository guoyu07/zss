<?php

namespace app\models\paylist;

use Yii;

/**
 * This is the model class for table "{{%coupon}}".
 *
 * @property integer $coupon_id
 * @property string $coupon_name
 * @property string $coupon_price
 * @property string $coupon_type
 * @property string $menu_id
 * @property integer $coupon_show
 * @property integer $updated_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $end_at
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupon}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_price'], 'number'],
            [['coupon_show', 'updated_id', 'created_at', 'updated_at', 'end_at'], 'integer'],
            [['coupon_name'], 'string', 'max' => 150],
            [['coupon_type', 'menu_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'coupon_id' => 'Coupon ID',
            'coupon_name' => 'Coupon Name',
            'coupon_price' => 'Coupon Price',
            'coupon_type' => 'Coupon Type',
            'menu_id' => 'Menu ID',
            'coupon_show' => 'Coupon Show',
            'updated_id' => 'Updated ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'end_at' => 'End At',
        ];
    }
	
	//查询登录用户下的优惠券信息
	public function getCoupon($userId)
	{
		$coupon_id = (new \yii\db\Query())
			->select(['coupon_id'])
			->from('zss_user')
			->where(['user_id' => $userId])
			->limit(1) 
			->One();

		
		if(empty($coupon_id['coupon_id'])){
			
			return 0;
		}else{
			return 1;
		}
	}
	
	
	//查询优惠券的信息
	public function getCouponinfo($userId){
		$coupon_id = (new \yii\db\Query())
			->select(['coupon_id'])
			->from('zss_user')
			->where(['user_id' => $userId])
			->limit(1) 
			->One();
		$coupon = trim($coupon_id['coupon_id'],',');
		return $this->find()
					->select(['coupon_name',
							  'coupon_price',
							  'coupon_id',
							  'coupon_money',
							  'end_at'
							])
					->where("coupon_id in ($coupon)")
					->asArray()
					->all();			

	}
}
