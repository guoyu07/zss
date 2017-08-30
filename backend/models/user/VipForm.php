<?php

namespace backend\models\user;

use yii\base\Model;
/**
 * 等级添加验证
 */
class VipForm extends Model
{
    public $vip_name;
    public $vip_discount;
    public $vip_price;
    public $vip_subtract;
    public $vip_experience;
    //public $gift;
    public function rules()
    {
        return [
            [['vip_name','vip_discount','vip_price','vip_subtract'],'required','message' => '不能为空'],
            ['vip_name','string','length' => [1, 30],'message'=>'长度至少在1到30个字符之间'],
            ['vip_name','unique','targetClass' => 'backend\models\user\Vip','message'=>'字段唯一性'],
            ['vip_discount','match','pattern' => '/^\d{1,2}$/','message'=>'数字在1-100之间'],
            ['vip_price','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'请输入1到8位数字'],
            ['vip_subtract','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'请输入1到8位数字'],
            ['vip_subtract','compattern'],
            ['vip_experience','match','pattern' => '/^\d{1,10}$/','message'=>'请输入1到10位数字'],
        ];
    }

     /**
     * 判断满减中,减的金钱要小满的
     */
    public function compattern()
    {
        $price = $this->vip_price;
        $subtract = $this->vip_subtract;
        if($subtract >= $price){
            $this->addError("vip_subtract","减的金钱要小于满的金钱");
        }
    }
}
