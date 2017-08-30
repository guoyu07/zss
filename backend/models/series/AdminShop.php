<?php

namespace backend\models\series;

use Yii;

/**
 * This is the model class for table "{{%admin_shop}}".
 *
 * @property integer $admin_id
 * @property integer $shop_id
 */
class AdminShop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_shop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'shop_id'], 'required'],
            [['admin_id', 'shop_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'adminID',
            'shop_id' => '店铺ID',
        ];
    }
}
