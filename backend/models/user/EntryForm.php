<?php

namespace backend\models\user;

use yii\base\Model;
/**
 * 公司添加验证
 */
class EntryForm extends Model
{
    public $company_name;
    public $company_discount;
    public $company_price;
    public $company_subtract;
    
    
    public function rules()
    {
        return [
            [['company_name','company_discount','company_price','company_subtract'],'required','message' => '不能为空'],
            ['company_name','string','length' => [1, 30],'message'=>'长度至少在1到30个字符之间'], 
            ['company_name','unique','targetClass' => 'backend\models\user\Company','message'=>'字段唯一性'], 
            ['company_discount','match','pattern' => '/^\d{1,2}$/','message'=>'数字在1-100之间'],
            ['company_price','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'请输入1到8位数字'],
            ['company_subtract','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'请输入1到位8数字'],
            ['company_subtract','compattern'],
        ];
    }
    
    /**
     * 判断满减中,减的金钱要小满的
     */
    public function compattern()
    {
        $price = $this->company_price;
        $subtract = $this->company_subtract;
        if($subtract >= $price){
            $this->addError("company_subtract","减的金钱要小于满的金钱"); 
        }
    }
}