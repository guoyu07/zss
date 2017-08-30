<?php

namespace backend\models\market;

use yii\base\Model;
/**
 * 等级添加验证
 */
class GiftForm extends Model
{
    public $gift_name;
	public $end_at;
	public $gift_num;
	public $gift_price;

    public function rules()
    {
        return [
			['gift_name','string','length' => [1, 30],'message'=>'长度至少在1到30个字符之间'], 
            [['gift_name','end_at','gift_num','gift_price'],'required','message'=>'必须填写.'],
			['gift_name','unique','targetClass'=>"\backend\models\market\Gift","message"=>"赠品名称已存在"],
			[['gift_price','gift_num'],'match','pattern'=>'/^\d{1,4}$/','message'=>'输入正确的值(不多于四位数).']
        ];
    }
}