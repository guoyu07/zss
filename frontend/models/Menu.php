<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $menu_id
 * @property string $menu_name
 * @property string $menu_code
 * @property integer $series_id
 * @property string $menu_price
 * @property string $menu_introduce
 * @property integer $menu_status
 * @property integer $shop_show
 * @property integer $menu_sort
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_id
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
            [['series_id', 'menu_status', 'shop_show', 'menu_sort', 'created_at', 'updated_at', 'updated_id'], 'integer'],
            [['menu_price'], 'number'],
            [['menu_name'], 'string', 'max' => 150],
            [['menu_code'], 'string', 'max' => 11],
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
            'menu_sort' => 'Menu Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_id' => 'Updated ID',
        ];
    }
    
    /*
     * 获取菜品信息
     * */
    
    public function GetMenu(){
        return $this->find()->where("menu_status = 1 and shop_show = 1")->asArray()->all();
    } 
}
