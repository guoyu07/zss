<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $order_id
 * @property integer $order_sn
 * @property integer $user_id
 * @property integer $shop_id
 * @property string $order_freight
 * @property integer $delivery_type
 * @property string $order_address
 * @property integer $seat_number
 * @property integer $meal_number
 * @property string $user_name
 * @property string $user_phone
 * @property string $order_payment
 * @property string $order_total
 * @property integer $gift_id
 * @property integer $pay_type
 * @property integer $pay_status
 * @property integer $pay_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $order_status
 * @property integer $discount_type
 * @property integer $discount
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'user_id', 'shop_id', 'delivery_type', 'seat_number', 'meal_number', 'gift_id', 'pay_type', 'pay_status', 'pay_at', 'created_at', 'updated_at', 'order_status', 'discount_type', 'discount'], 'integer'],
            [['order_freight', 'order_payment', 'order_total'], 'number'],
            [['order_address', 'user_name'], 'string', 'max' => 30],
            [['user_phone'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'shop_id' => 'Shop ID',
            'order_freight' => 'Order Freight',
            'delivery_type' => 'Delivery Type',
            'order_address' => 'Order Address',
            'seat_number' => 'Seat Number',
            'meal_number' => 'Meal Number',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'order_payment' => 'Order Payment',
            'order_total' => 'Order Total',
            'gift_id' => 'Gift ID',
            'pay_type' => 'Pay Type',
            'pay_status' => 'Pay Status',
            'pay_at' => 'Pay At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'order_status' => 'Order Status',
            'discount_type' => 'Discount Type',
            'discount' => 'Discount',
        ];
    }
}
