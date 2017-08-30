<?php

namespace backend\models\market;

use Yii;
use backend\models\series\Menu;


/**
 * This is the model class for table "{{%discount}}".
 *
 * @property integer $discount_id
 * @property integer $discount_num
 * @property integer $discount_to_com
 * @property integer $discount_to_menu
 * @property integer $discount_show
 * @property integer $created_at
 * @property integer $updated_at
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discount}}';
    }   

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discount_num','discount_show', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discount_id' => '自增id',
            'discount_num' => '折扣百分比',
            'discount_show' => '是否显示',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
	//查询所有的折扣
	public function getAll()
	{
		 return $this->find()
			 ->select(["zss_discount.created_at",
			 "zss_discount.updated_at",
			 "zss_discount.discount_id",
			 "zss_discount.discount_num",
			 "zss_admin.username",
			 "zss_discount.discount_show"])
			 ->innerjoin("`zss_admin` on `zss_discount`.`updated_id` = `zss_admin`.`id`")
			 ->asArray()
			 ->all();

	}
	//查询未用过的折扣
	public function searchnone()
	{
		 return $this->find()
			 ->select(["zss_discount.created_at",
			 "zss_discount.updated_at",
			 "zss_discount.discount_id",
			 "zss_discount.discount_num",
			 "zss_admin.username",
			 "zss_discount.discount_show"])
			 ->innerjoin("`zss_admin` on `zss_discount`.`updated_id` = `zss_admin`.`id`")
			 ->where("zss_discount.discount_to_menu = ''")
			 ->asArray()
			 ->all();
	}


	//删除选中的折扣
	 public function delOne($id)
	 {
		return $this->findOne($id)->delete();
	 }


	//新添加折扣
	public function add_discount($data){
		$this->discount_num = $data['DiscountForm']['discount_num'];//添加折扣比例
		$this->discount_show = $data['discount_show'];				///添加折扣是否显示
		$this->updated_id = Yii::$app->user->identity->id;//修改人
		$this->created_at = time();
		$this->updated_at = time();									///修改时间

		return $this->save();
	}

	//返回修改的数据信息
	public function getOne($id){

		return $this->findOne($id);
	}


	//修改选中的数据信息
	public function update_discount($data,$id)
	{
		$discount = $this->findOne($id);

		$discount->discount_num = $data['DiscountForm']['discount_num'];//折扣比
		$discount->discount_show = $data['discount_show'];				//修改显示状态
		$discount->updated_id = Yii::$app->user->identity->id;//修改人
		$discount->updated_at = time();									//修改时间
		return $discount->save();								//返回修改结果
	}

	//修改选中信息的显示状态
	public function ChangeOneShow($data)
	{
		$discount = $this->findOne($data['id']);
		if($data['show'] == 1){
			$discount->discount_show = 0;
		}
		if($data['show'] == 0){
			$discount->discount_show = 1;
		}
		return $discount->save();
	}
	//获取单条折扣的详情
	public function getOneinfo($data)
	{
	    $discountinfo = $this->find()
			->select(["discount_id",
			"discount_num",
			"discount_show",
			"zss_discount.created_at as start_at",
			"zss_discount.updated_at as upd_at",
			"zss_admin.username"])
			->innerjoin("`zss_admin` on `zss_discount`.`updated_id` = `zss_admin`.`id`")
			->where(["zss_discount.discount_id"=>$data['id']])
			->asArray()
			->One();
		$discountinfo['created_at'] = date("Y-m-d",$discountinfo['start_at']);
		$discountinfo['updated_at'] = date("Y-m-d",$discountinfo['upd_at']);
		if($discountinfo['discount_show'] == 1){
			$discountinfo['discount_show']="是";
		}
		if($discountinfo['discount_show'] == 1){
			$discountinfo['discount_show'] = "否";
		}
		return $discountinfo;
	}
	 //批量删除折扣
	 public function delmore($str)
	{
		return $this->deleteAll(["in","discount_id",$str]);
	 }
	 
}
