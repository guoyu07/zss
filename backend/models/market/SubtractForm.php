<?php

namespace backend\models\market;

use yii\base\Model;
/**
 * 等级添加验证
 */
class SubtractForm extends Model
{
    public $subtract_price;
	public $subtract_subtract;

    public function rules()
    {
        return [
            [['subtract_price','subtract_subtract'],'required','message'=>'必须填写.'],
			['subtract_price','unique','targetClass'=>"\backend\models\market\Subtract","message"=>"满减值已存在"],
			[['subtract_price','subtract_subtract'],'match','pattern'=>'/^\d{1,6}$/','message'=>'输入正确的值（数字1-999999）.'],
        ];
    }
}