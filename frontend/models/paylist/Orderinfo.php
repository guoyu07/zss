<?php

namespace app\models\paylist;

use Yii;


/**
 * This is the model class for table "{{%order_info}}".
 *
 * @property integer $info_id
 * @property integer $order_id
 * @property integer $menu_id
 * @property integer $menu_num
 * @property string $menu_price
 * @property integer $created_at
 */
class Orderinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'menu_id', 'menu_num', 'created_at'], 'integer'],
            [['menu_price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'info_id' => 'Info ID',
            'order_id' => 'Order ID',
            'menu_id' => 'Menu ID',
            'menu_num' => 'Menu Num',
            'menu_price' => 'Menu Price',
            'created_at' => 'Created At',
        ];
    }
	
	public function add($data)
	{
		//添加订单详情数据
		print_R($data);


	}
}
