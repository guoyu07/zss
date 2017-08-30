<?php

namespace backend\models\market;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $menu_id
 * @property string $menu_name
 * @property integer $menu_code
 * @property integer $series_id
 * @property string $menu_price
 * @property string $menu_introduce
 * @property integer $menu_status
 * @property integer $shop_show
 * @property integer $shop_sort
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $image_url
 * @property string $image_wx
 * @property string $image_pc
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_code', 'series_id', 'menu_status', 'shop_show', 'shop_sort', 'created_at', 'updated_at'], 'integer'],
            [['menu_price'], 'number'],
            [['menu_name'], 'string', 'max' => 150],
            [['menu_introduce'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'menu_name' => 'Menu Name',
            'menu_code' => 'Menu Code',
            'series_id' => 'Series ID',
            'menu_price' => 'Menu Price',
            'menu_introduce' => 'Menu Introduce',
            'menu_status' => 'Menu Status',
            'shop_show' => 'Shop Show',
            'shop_sort' => 'Shop Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            
        ];
    }
    //数据菜单数据
    public function select()
    {   
       return  $this->find()->asArray()->all();
       
    }    
}
