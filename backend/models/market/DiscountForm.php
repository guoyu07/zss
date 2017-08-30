<?php

namespace backend\models\market;

use yii\base\Model;
/**
 * 等级添加验证
 */
class DiscountForm extends Model
{
    public $discount_num;

    public function rules()
    {
        return [
            ['discount_num','required','message' => '不能为空'],
			['discount_num','unique','targetClass'=>"\backend\models\market\Discount","message"=>"折扣值已存在"],
            ['discount_num','number','message'=>'请输入数字'],
			['discount_num','match','pattern'=>'/^\d{1,2}$/','message'=>'输入正确的值.'],
        ];
	 }
}