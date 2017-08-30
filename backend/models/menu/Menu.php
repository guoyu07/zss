<?php

namespace backend\models\menu;

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
            [['series_id', 'menu_status', 'shop_show', 'menu_sort', 'created_at', 'updated_at'], 'integer'],
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
            'menu_id' => '菜品id',
            'menu_name' => '菜品name',
            'menu_code' => '菜品code',
            'series_id' => '所属分类',
            'menu_price' => '菜品原价',
            'menu_introduce' => '菜品介绍',
            'menu_status' => '状态 0关闭 1开启默认',
            'shop_show' => '是否显示 0不显示 1显示默认',
            'menu_sort' => '排序默认50',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @params $filed array  字段列表
     * @params $params  array 参数列表
     */
      public function find_all($filed,$where = "1=1")
      {
        return $this
                ->find()
                ->from('zss_menu as m')
                ->select($filed)
                ->where($where)
                ->innerJoin('zss_series as s','m.series_id = s.series_id')
                ->asArray()
                ->all();
      }

    /**
     * @params $filed array  字段列表
     */
    public function menu_infos($filed,$where = "1=1")
    {
      $menu = $this->find_all($filed,$where);
      $image = (new \yii\db\Query())->from('zss_image')->select(['image_url'])->where(['model_id' => $menu[0]['menu_id']])->one();
      $menu[0]['image'] = $image['image_url'];
      return $menu[0];
    }
}
