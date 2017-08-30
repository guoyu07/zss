<?php

namespace backend\models\user;

use Yii;

/**
 * This is the model class for table "{{%gift}}".
 *
 * @property integer $gift_id
 * @property string $gift_name
 * @property integer $gift_num
 * @property string $gift_price
 * @property integer $updated_at
 * @property integer $end_at
 * @property integer $created_at
 */
class Gift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gift}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gift_num', 'updated_at', 'end_at', 'created_at'], 'integer'],
            [['gift_price'], 'number'],
            [['gift_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gift_id' => '赠品自增id',
            'gift_name' => '赠品名称',
            'gift_num' => '赠品数量',
            'gift_price' => '赠品价格',
            'updated_at' => '修改时间',
            'end_at' => '结束时间',
            'created_at' => '创建时间',
        ];
    }
}
