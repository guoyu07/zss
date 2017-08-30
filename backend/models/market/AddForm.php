<?php

namespace backend\models\market;

use yii\base\Model;
/**
 * 等级添加验证
 */
class AddForm extends Model
{
    public $add_price;

    public function rules()
    {
        return [
             ['add_price','required','message'=>'必须填写.'],
			 ['add_price','unique','targetClass'=>"\backend\models\market\Add","message"=>"满赠值已存在"],
			 ['add_price','match','pattern'=>'/^\d{2,6}$/','message'=>'输入大于25小于999999.'],
        ];
    }
}