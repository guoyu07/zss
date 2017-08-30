<?php

namespace backend\models\market;

use yii\base\Model;
/**
 * 等级添加验证
 */
class CouponForm extends Model
{
    public $coupon_name;
	public $coupon_price;
	public $end_time;
	
    public function rules()
    {
        return [
		   ['coupon_name','string','length' => [1, 30],'message'=>'长度至少在1到30个字符之间'], 
		   ['coupon_name','unique','targetClass'=>"\backend\models\market\Coupon","message"=>"折扣已存在"],
           [['coupon_name','coupon_price','end_time'],'required','message'=>'必须填写.'],
		   ['coupon_price','match','pattern'=>'/^\d{1,4}$/','message'=>'输入正确的值(不多于四位数).']
        ];
    }
}