<?php

namespace backend\models\market;

use yii\base\Model;
/**
 * 等级添加验证
 */
class WalletupForm extends Model
{
    public $wallet_name;
	public $wallet_price;
	public $wallet_share;
	public $wallet_template;
    public function rules()
    {
        return [
			['wallet_name','string','length' => [1, 30],'message'=>'长度至少在1到30个字符之间'], 
            [['wallet_name'],'required','message'=>'必须填写.'],
			[['wallet_price','wallet_share'],'match','pattern'=>'/^\d{1,5}$/','message'=>'输入正确的值（数字）.']
        ];
    }
}