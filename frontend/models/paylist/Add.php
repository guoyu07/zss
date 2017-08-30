<?php

namespace app\models\paylist;

use Yii;

/**
 * This is the model class for table "{{%add}}".
 *
 * @property integer $add_id
 * @property string $add_price
 * @property integer $gift_id
 * @property integer $add_show
 * @property integer $created_at
 * @property integer $updated_at
 */
class Add extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%add}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['add_price'], 'number'],
            [['gift_id', 'add_show', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'add_id' => '自增id',
            'add_price' => '满足条件的金额',
            'gift_id' => '赠品id',
            'add_show' => '是否显示',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

	//查询满赠列表
	public function selectadd()
	{
		 return $this->find()
			 ->select(["zss_add.add_price",
			 "zss_gift.gift_name"])
			 ->innerjoin("`zss_gift` on `zss_add`.`gift_id` = `zss_gift`.`gift_id`")
			 ->asArray()
			 ->all();
	}
}
