<?php

namespace app\models\paylist;

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
	 
	 public function selectShop($shopid){
		 
		 return $this->find()
			->where("shop_id = ".$shopid)
			->asarray()
			->one();
	 }
}
