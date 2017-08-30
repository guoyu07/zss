<?php

namespace app\models\paylist;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%shop_menu}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $shop_id
 * @property integer $menu_stock
 * @property integer $is_show
 * @property integer $discount_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $menu_desc
 * @property integer $updated_id
 */
class ShopMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'shop_id', 'menu_stock', 'is_show', 'discount_id', 'created_at', 'updated_at', 'updated_id'], 'integer'],
            [['menu_desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'shop_id' => 'Shop ID',
            'menu_stock' => 'Menu Stock',
            'is_show' => 'Is Show',
            'discount_id' => 'Discount ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'menu_desc' => 'Menu Desc',
            'updated_id' => 'Updated ID',
        ];
    }
	
	public function updnum($shopid,$ordersn){
		$orderinfo = (new \yii\db\Query()) 
			->select(['zss_order_info.menu_id','zss_order_info.menu_num','zss_order.shop_id','zss_order.order_id'])   
			->from('zss_order')
			->innerjoin("`zss_order_info` on `zss_order_info`.`order_id` = `zss_order`.`order_id`")
			->where("zss_order.order_sn = ".$ordersn) 
			->all();
		$num = count($orderinfo);
		$i = 0;
		foreach($orderinfo as $k=>$v){		
			$info = $this->find()
					->where(['menu_id' => $v['menu_id'],'shop_id' => $v['shop_id']])
					->One();
				$info -> menu_stock = $info->menu_stock - $v['menu_num'];
				if($info->save()){
					$i++;
				}
					
		}
		if($num == $i){
			return "success";
		}
			
	}
    
}
