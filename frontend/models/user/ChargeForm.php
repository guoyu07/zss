<?php
namespace frontend\models\user;

use yii\base\Model;

/**
 * Signup form
 */
class ChargeForm extends Model
{
    public $money;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['money', 'required','message'=>'不能为空'],
            ['money','match','pattern'=>'/^([1-9]{0,1}\d{1,5})$/','message'=>'请输入正确的金额'],   
        ];
    }


}
