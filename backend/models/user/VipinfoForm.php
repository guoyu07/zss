<?php

namespace backend\models\user;

use Yii;

/**
 * This is the model class for table "{{%vip}}".
 *
 * @property integer $vip_id
 * @property string $vip_name
 * @property integer $vip_discount
 * @property string $vip_subtract
 * @property integer $gift_id
 * @property integer $vip_status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_id
 * @property string $vip_price
 */
class VipinfoForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vip}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_discount', 'gift_id', 'vip_status', 'created_at', 'updated_at', 'updated_id'], 'integer'],[['vip_name','vip_discount','vip_price','vip_subtract'],'required','message' => '不能为空'],
            [['vip_subtract', 'vip_price'], 'number'],
            [['vip_name'], 'string', 'max' => 30],
            [['vip_name','vip_discount','vip_price','vip_subtract'],'required','message' => '不能为空'],
            ['vip_name','string','length' => [1, 30],'message'=>'长度至少在1到30个字符之间'], 
            //['vip_name','checkname','message'=>'字段唯一性'], 
            ['vip_discount','string','length' => [1, 2],'message'=>'数字在1-100之间'],
            ['vip_price','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'长度过长,请输入1到8金钱'],
            ['vip_subtract','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'长度过长,请输入1到8金钱'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vip_id' => '自增ID  ',
            'vip_name' => 'vip名称',
            'vip_discount' => '折扣百分比',
            'vip_subtract' => '减多少',
            'gift_id' => '赠品的id',
            'vip_status' => '是否使用 0禁用    1使用',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'updated_id' => '修改人id',
            'vip_price' => '满多少',
        ];
    }
    
    /**
     * 判断修改时名字是否可靠
     * @params $newname 现在输入的名字
     * @params $oldname 原来的名字
     */
    public function checkname($newname,$oldname)
    {
        //$err = $this->vip_name; 
        $only = Vip::find()->where(['vip_name' => $newname])->asArray()->one();
        if($only){
            $all = Vip::find()->asArray()->all();
            foreach($all as $kk => $vv){
                if($vv['vip_name'] == $oldname){
                    unset($all[$kk]);
                }else{
                    $arr[]=$vv['vip_name'];
                }
                
            }
            if(in_array($newname, $arr)){
                 $this->addError('vip_name', '不可重复'); 
                 return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
        
    }
}
