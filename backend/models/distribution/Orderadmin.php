<?php

namespace backend\models\distribution;
use backend\models\order\Order;

use Yii;

/**
 * This is the model class for table "{{%order_admin}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $admin_id
 * @property integer $add_time
 */
class Orderadmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'admin_id', 'add_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'admin_id' => '配送员id',
            'add_time' => 'Add Time',
        ];
    }
	
	/**
	*@取得已经抢到的单
	*/
	function meorder($where = '')
	{
		return Order::find()
				->select('*')
				->innerJoin("zss_order_admin","zss_order_admin.order_id = zss_order.order_id")
				->innerJoin("zss_site","zss_site.site_id = zss_order.order_address")
				->where($where)
				->asArray()
				->all();
	}

	/**
	* 取得所有匹配管理
	*/
	function AllOrder()
	{
		$list = $this->find()
				->select('*')
				->leftJoin("zss_order","zss_order.order_id = zss_order_admin.order_id")
				->leftJoin("zss_site","zss_site.site_id = zss_order.order_address")
				->asArray()
				->all();
		foreach($list as $key=>$val)
		{
			$rows = (new \yii\db\Query())    ->select(['username'])->from('zss_admin')->where(['id' => $val['admin_id']])->one();
			$list[$key]['username'] = $rows['username'];
		}
		return $list;
	}


}
