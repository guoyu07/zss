<?php

namespace backend\models\user;

use Yii;

/**
 * This is the model class for table "{{%vip_info}}".
 *
 * @property integer $vip_info_id
 * @property string $vip_experience_get
 * @property string $vip_experience_raiders
 */
class VipInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vip_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_experience_get', 'vip_experience_raiders'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vip_info_id' => 'Vip Info ID',
            'vip_experience_get' => '经验值获取',
            'vip_experience_raiders' => '经验获取攻略',
        ];
    }

    /**
     * 获取信息
     */
    public function get_info()
    {
        return $this->find()->orderBy(['vip_info_id'=>SORT_DESC])->asArray()->one();
    }

    /**
     * 修改信息
     */
    public function upd_info($vip_experience_get,$vip_experience_raiders)
    {
        $info = $this->findOne(1);
        $info->vip_experience_get = $vip_experience_get;
        $info->vip_experience_raiders = $vip_experience_raiders;
        return $info->save();
    }
}
