<?php

namespace backend\models\user;

use Yii;

/**
 * This is the model class for table "{{%vip_charge}}".
 *
 * @property integer $vip_charge_id
 * @property integer $user_id
 * @property string $charge_money
 * @property integer $created_at
 */
class VipCharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vip_charge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['charge_money'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vip_charge_id' => '自增ID',
            'user_id' => '用户id',
            'charge_money' => '充值金额',
            'created_at' => '添加时间',
        ];
    }
    
    /**
     * 根据user_id查取最近几条充值记录
     * $params $user_id 用户id
     */
    public function selectlast($user_id){
        return $this->find()->where(['user_id' => $user_id])->limit(3)->orderBy("created_at DESC")->asArray()->all();
    }
}
