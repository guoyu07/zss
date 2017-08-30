<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Signup form
 */
class AddressForm extends Model
{
    public $username;
    public $phone;
    public $address;
    public $localnum;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'phone','address','localnum'], 'required','message'=>'不能为空'],
            ['username','string','length' => [1, 15],'message'=>'请输入正确的长度'], 
            ['phone','match','pattern' => '/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/','message'=>'请输入正确的手机号'],            ['address','string','length' => [1, 30],'message'=>'请输入正确的地址'],    
            //['localnum','match','pattern'=>'/^[a-zA-Z]+[(\x{4E00}-\x{9FA5})-[(\x{4E00}-\x{9FA5})]*$/u','message'=>'请输入正确格式的地址'],
        ];
    }


}
