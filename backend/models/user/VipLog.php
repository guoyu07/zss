<?php

namespace backend\models\user;

use Yii;

/**
 * This is the model class for table "{{%vip_log}}".
 *
 * @property integer $vip_log_id
 * @property string $user_name
 * @property string $user_phone
 * @property string $user_password
 * @property string $user_price
 * @property integer $user_virtual
 * @property string $user_sex
 * @property integer $company_name
 * @property integer $discount
 * @property integer $full
 * @property integer $cut
 * @property string $gift_name
 * @property string $order_sn
 * @property string $order_freight
 * @property integer $delivery_type
 * @property string $order_address
 * @property integer $seat_number
 * @property string $order_payment
 * @property string $order_total
 * @property integer $pay_type
 * @property integer $pay_status
 * @property integer $pay_at
 * @property integer $order_status
 * @property string $menu_name
 * @property string $menu_num
 * @property string $menu_price
 * @property string $pay_price
 * @property string $menu_introduce
 * @property string $image_url
 * @property string $image_wx
 * @property string $image_pc
 * @property string $shop_name
 * @property string $series_name
 * @property integer $created_at
 * @property string $menu_desc
 */
class VipLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vip_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_price', 'order_freight', 'order_payment', 'order_total'], 'number'],
            [['user_virtual', 'company_name', 'discount', 'full', 'cut', 'delivery_type', 'seat_number', 'pay_type', 'pay_status', 'pay_at', 'order_status', 'created_at'], 'integer'],
            [['user_name', 'order_address', 'menu_desc'], 'string', 'max' => 50],
            [['user_phone'], 'string', 'max' => 11],
            [['user_password', 'gift_name', 'order_sn'], 'string', 'max' => 30],
            [['user_sex'], 'string', 'max' => 2],
            [['menu_name', 'menu_num', 'menu_price', 'pay_price', 'image_url', 'image_wx', 'image_pc'], 'string', 'max' => 100],
            [['menu_introduce'], 'string', 'max' => 200],
            [['shop_name', 'series_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vip_log_id' => '自增ID',
            'user_name' => '用户名',
            'user_phone' => '用户手机号',
            'user_password' => '用户密码',
            'user_price' => '用户余额',
            'user_virtual' => '用户积分',
            'user_sex' => '用户性别',
            'company_name' => '用户所属公司名',
            'discount' => '折扣',
            'full' => '满多少',
            'cut' => '减多少',
            'gift_name' => '赠品名称',
            'order_sn' => 'Order Sn',
            'order_freight' => '运费',
            'delivery_type' => '支付类型',
            'order_address' => 'Order Address',
            'seat_number' => 'Seat Number',
            'order_payment' => '订单实付款',
            'order_total' => '总价格',
            'pay_type' => '支付类型',
            'pay_status' => '支付状态',
            'pay_at' => '支付时间',
            'order_status' => '订单状态',
            'menu_name' => '菜品名称',
            'menu_num' => '菜品数量',
            'menu_price' => '菜品现价',
            'pay_price' => '菜品售价',
            'menu_introduce' => '菜品介绍',
            'image_url' => '菜品原图',
            'image_wx' => '菜品微信端图',
            'image_pc' => '菜品pc端图',
            'shop_name' => '门店名称',
            'series_name' => '分类名称',
            'created_at' => '记录时间',
            'menu_desc' => '菜品描述',
        ];
    }
}
