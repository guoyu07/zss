<?php

namespace frontend\models\user;

use Yii;

/**
 * This is the model class for table "{{%site}}".
 *
 * @property integer $site_id
 * @property string $site_name
 * @property string $site_phone
 * @property string $site_detail
 * @property string $site_sex
 * @property integer $created_at
 * @property integer $user_id
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'user_id'], 'integer'],
            [['site_name'], 'string', 'max' => 30],
            [['site_phone'], 'string', 'max' => 11],
            [['site_detail'], 'string', 'max' => 100],
            [['site_sex'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'site_id' => 'Site ID',
            'site_name' => 'Site Name',
            'site_phone' => 'Site Phone',
            'site_detail' => 'Site Detail',
            'site_sex' => 'Site Sex',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
        ];
    }
    
    /**
     * 把原来site_status的状态改为0
     */
    /*public function changeold(){
        $customer = $this->find()->where(['user_id' => 73])->one();
        $customer->site_status = 1;
        return $customer->save(); 
    }*/
}
