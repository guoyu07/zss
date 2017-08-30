<?php

namespace backend\models\user;

use yii\base\Model;
/**
 * 用户添加验证
 */
class MemberForm extends Model
{
    public $user_name;
    public $user_sex;
    public $user_phone;
    public $user_password;
    public $user_repassword;
    public $user_price;
    public $user_virtual;
    public function rules()
    {
        return [
            [['user_name','user_sex','user_phone','user_password','user_price','user_virtual'],'required','message' => '不能为空'],
            ['user_name','string','length' => [1, 15],'message'=>'长度至少在1到15个字符之间'], 
            ['user_name','unique','targetClass' => 'backend\models\user\User','message'=>'字段唯一性'], 
            ['user_sex','string','length' => [1, 2],'message'=>'长度在1到2个之间'],
            ['user_password', 'string', 'min' => 6, 'max' => 16, 'message' => '6-16位数字或字母'],
            ['user_repassword', 'compare', 'compareAttribute' => 'user_password', 'message' => '两次密码不一致'],
            ['user_phone','match','pattern' => '/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/','message'=>'请输入正确的手机号'],
            ['user_price','match','pattern'=>'/^\d{1,8}$/','message'=>'长度过长,请输入1到8金钱'],
            ['user_virtual','match','pattern'=>'/^\d{1,5}$/','message'=>'长度过长,请输入1到5位积分'],
        ];
    }
}