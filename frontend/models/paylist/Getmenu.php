<?php

namespace app\models\paylist;

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
class Getmenu extends \yii\db\ActiveRecord
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
	
	//查询订单页面的菜品信息（名称，价格，数量）
	public  function getInfo($menu)
	{
		//菜品的ID和菜品对应的数量
		$menu_id = array();//Id
		$menu_num = array();//数量
		foreach($menu as $k=>$v){
			$menu_id[] = $v['menu'];
			$menu_num[] = $v['num'];
		}
		$menustr = implode($menu_id,',');//把数组格式的id转换成字符串
		
		$menuInfo = $this->find()
		->select([
			'menu_name',
			'menu_price',
			'menu_id',
		])
		->where(" menu_id in ($menustr)")
		->asArray()->all();
		
		foreach($menuInfo as $kk=>$vv){
			$menuInfo[$kk]['num'] = $menu_num[$kk];
		}
		return $menuInfo;
	}
}
