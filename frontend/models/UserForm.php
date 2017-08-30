<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $user_phone;
    public $yanz;
    public $xyi;
   

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_phone', 'required','message'=>"手机号不能为空"],
            ['yanz', 'required','message'=>"验证码不能为空"],
             ['xyi', 'required'],
            ['user_phone', 'number','min'=>11111111111,'max'=>99999999999,'message'=>"手机号格式不对"],           
        ];
    }

   
}
