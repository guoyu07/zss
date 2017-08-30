<?php

namespace backend\models\order;

use Yii;
use backend\models\menu\Menu;
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
            [['order_id', 'menu_id', 'menu_num', 'created_at','strat_time'], 'integer'],
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
			'strat_time' => '开始时间',
        ];
    }
	
	 /**
     * @inheritdoc 查询订单的详细信息
     */
	function order_info($getData)
	{
		return $this->find()
				->select(["menu_name","series_name","menu_introduce","menu_num","zss_menu.menu_price"])
				->innerJoin("`zss_menu` on `zss_menu`.`menu_id` = `zss_order_info`.`menu_id`")
				->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
				->where(['zss_order_info.order_id'=>$getData['order_id']])
				->asArray()
				->all();
	}
     /**
     * @inheritdoc 查询订单各档口的详细信息
     */
    function order_series_info($getData)
    {

        return $this->find()
                ->select(["menu_name","series_name","menu_introduce","zss_menu.menu_price","menu_num","print_name","info_id","zss_print.print_id","zss_series.series_id","zss_print.print_num"])
                ->innerJoin("`zss_menu` on `zss_menu`.`menu_id` = `zss_order_info`.`menu_id`")
                ->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
                ->leftjoin("`zss_print` on  `zss_print`.`series_id`= `zss_series`.`series_id`")
                ->where(['zss_order_info.order_id'=>$getData['order_id']])
                ->asArray()
                ->all();
    }
	
	/**
	*@Action 打印订单 添加菜的时间
	*/
	function printer($id)
	{		
		$db = Yii::$app->db;
		return $db->createCommand("update zss_order_info set strat_time= :strat_time where order_id = :id", [
			':strat_time' => time(),
			':id' => $id,
		])->execute();
	}
}
