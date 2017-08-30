<?php

namespace backend\models\shop;

use Yii;

/**
 * This is the model class for table "{{%admin_distribution}}".
 *
 * @property integer $admin_id
 * @property integer $shop_id
 */
class AdminDistribution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_distribution}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'shop_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'shop_id' => 'Shop ID',
        ];
    }
}
