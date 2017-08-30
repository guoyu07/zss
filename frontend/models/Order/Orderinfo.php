<?php

namespace frontend\models\Order;

use Yii;
use yii\helpers\VarDumper;
use yii\db\Expression;
use app\models\Menu;
use app\models\ShopMenu;

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
            'info_id' => '订单详情ID',
            'order_id' => '订单id',
            'menu_id' => '菜品id',
            'menu_num' => '菜品个数',
            'menu_price' => '价格',
            'created_at' => '添加时间',
        ];
    }

	/**
     *@Action 订单详情
	 *@param $id 订单的id
     */
	 public function OrderList($id)
	{
		 return $this->find()
				->select(["zss_order_info.menu_id","zss_order_info.menu_num","zss_order_info.menu_price","zss_order_info.created_at","zss_menu.menu_name","zss_menu.menu_code"])
				->leftJoin("zss_menu","zss_menu.menu_id = zss_order_info.menu_id")
				->where(["order_id"=>$id])
				->asArray()
				->all();
	}
	
	/*
	 * 热门商品
	 * */
	public function HotInfo($shop_id,$serimg){
	    $quert = $this->find()->select(['menu_id'])->groupBy('menu_id')->orderBy([new Expression('count(menu_id) desc')])->limit(3)->asArray()
	    ->all();
	    if($quert){
	        foreach($quert as $qk=>$qv){
	            $arr[] = $qv['menu_id'];
	        }
	        $in = implode($arr,',');
   
	    $hot_data = ShopMenu::find()
	    ->select(['zss_menu.menu_id','menu_name','menu_stock','zss_menu.menu_price','image_wx','menu_introduce','img1','img2'])
	    ->innerJoin("`zss_menu` on `zss_shop_menu`.`menu_id` = `zss_menu`.`menu_id`")
	    ->innerJoin("`zss_image` on `zss_menu`.`menu_id` = `zss_image`.`model_id`")
	    ->innerJoin("`zss_series` on `zss_menu`.`series_id` = `zss_series`.`series_id`")
	    ->where("zss_shop_menu.shop_id = $shop_id && menu_stock > 0 && `zss_shop_menu`.`is_show` = 1 && zss_menu.menu_id in($in)")
	    ->asArray()->all();
	    
	    if($hot_data){
	        foreach ($hot_data as $sk=>$sv){
	            $count = count($serimg);
	            $serimg[$count]['series_img1'] = $sv['img1'];
	            $serimg[$count]['series_img2'] = $sv['img2'];
	            $count++;
	        }
	        
	        unset($hot_data[$sk]['img1']);unset($hot_data[$sk]['img2']);
	         
	        $hot_data[$sk]['series_name'] = '热卖';
	        $hot[0] = $hot_data;
	        $hot[1] = $serimg;
	        return $hot;
	    }
	    }else{
	        return 0;//0代表暂无热门商品
	    }
	}

}
