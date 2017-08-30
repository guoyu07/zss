<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%shop}}".
 *
 * @property integer $shop_id
 * @property string $shop_name
 * @property integer $shop_status
 * @property string $shop_x
 * @property string $shop_y
 * @property string $shop_address
 * @property string $shop_tel
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_id
 * @property string $distribution
 * @property string $lunchbox
 * @property integer $add_id
 * @property integer $subtract_id
 * @property integer $eat_start_time
 * @property integer $eat_end_time
 * @property integer $takeaway_start_time
 * @property integer $takeaway_end_time
 * @property string $shop_remark
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_status', 'created_at', 'updated_at', 'updated_id', 'add_id', 'subtract_id', 'eat_start_time', 'eat_end_time', 'takeaway_start_time', 'takeaway_end_time'], 'integer'],
            [['shop_x', 'shop_y', 'distribution', 'lunchbox'], 'number'],
            [['shop_name'], 'string', 'max' => 100],
            [['shop_address', 'shop_remark'], 'string', 'max' => 255],
            [['shop_tel'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shop_id' => 'Shop ID',
            'shop_name' => 'Shop Name',
            'shop_status' => 'Shop Status',
            'shop_x' => 'Shop X',
            'shop_y' => 'Shop Y',
            'shop_address' => 'Shop Address',
            'shop_tel' => 'Shop Tel',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_id' => 'Updated ID',
            'distribution' => 'Distribution',
            'lunchbox' => 'Lunchbox',
            'add_id' => 'Add ID',
            'subtract_id' => 'Subtract ID',
            'eat_start_time' => 'Eat Start Time',
            'eat_end_time' => 'Eat End Time',
            'takeaway_start_time' => 'Takeaway Start Time',
            'takeaway_end_time' => 'Takeaway End Time',
            'shop_remark' => 'Shop Remark',
        ];
    }
    
    /*
     * 取出所有的门店信息
     * */
    public function AllShop(){
        return $this->find()->select(['shop_id','shop_x','shop_y'])->asArray()->all();
    }
    
    /*
     * 取出最近门店名称
     * */
    public function ShopOne($shop_id){
        $shop_data = $this->find()->select(['shop_name'])->where("shop_id = $shop_id")->asArray()->one();
        return $shop_data['shop_name'];
    }
   
}
